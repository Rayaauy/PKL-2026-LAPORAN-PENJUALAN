<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->transactions()
            ->with('items')
            ->latest('transaction_date');

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $transactions = $query->paginate(20)->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = auth()->user()->products()
            ->where('is_active', true)
            ->get();
        
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date'   => 'required|date|before_or_equal:today',
            'notes'              => 'nullable|string|max:500',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $code = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            $transaction = auth()->user()->transactions()->create([
                'transaction_code' => $code,
                'transaction_date' => $request->transaction_date,
                'notes'            => $request->notes,
                'total_amount'     => 0,
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                // Fetch price from DB — never trust frontend value.
                // findOrFail scoped to auth user prevents IDOR.
                $product  = auth()->user()->products()
                    ->where('is_active', true)
                    ->findOrFail($item['product_id']);

                $qty      = (int) $item['quantity'];
                $subtotal = $product->price * $qty;
                $total   += $subtotal;

                $transaction->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'price'        => $product->price,
                    'quantity'     => $qty,
                    'subtotal'     => $subtotal,
                ]);
            }

            $transaction->update(['total_amount' => $total]);

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil dicatat.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Produk tidak valid atau tidak aktif.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menyimpan transaksi. Silakan coba lagi.');
        }
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        $transaction->load('items.product');
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
