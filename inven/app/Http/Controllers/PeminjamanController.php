<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Commodity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['commodity'])->latest()->get();
        $commodities = Commodity::all();
        $title = 'Manajemen Peminjaman';
        $page_heading = 'Data Peminjaman';

        return view('peminjaman.index', compact('loans', 'commodities', 'title', 'page_heading'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'commodity_id' => 'required|exists:commodities,id',
            'borrower_name' => 'required|string|max:255',
            'borrower_phone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
            'purpose' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $validated = $validator->validated();
            $commodity = Commodity::findOrFail($validated['commodity_id']);

            // Check if requested quantity is available
            $borrowedQuantity = Loan::where('commodity_id', $commodity->id)
                ->where('status', 'borrowed')
                ->sum('quantity');

            $availableQuantity = $commodity->quantity - $borrowedQuantity;

            if ($validated['quantity'] > $availableQuantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jumlah barang tidak mencukupi! Tersisa: ' . $availableQuantity
                ], 422);
            }

            // Create Loan
            $loan = new Loan();
            $loan->user_id = auth()->id();
            $loan->commodity_id = $validated['commodity_id'];
            $loan->borrower_name = $validated['borrower_name'];
            $loan->borrower_phone = $validated['borrower_phone'];
            $loan->quantity = $validated['quantity'];
            $loan->loan_date = $validated['loan_date'];
            $loan->due_date = $validated['due_date'];
            $loan->purpose = $validated['purpose'];
            $loan->notes = $validated['notes'] ?? null;
            $loan->status = 'borrowed';
            $loan->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Peminjaman berhasil ditambahkan.',
                'data' => $loan
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating loan: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan peminjaman.'
            ], 500);
        }
    }

    public function show(Loan $peminjaman)
    {
        try {
            $peminjaman->load('commodity');
            Log::info('Show loan request', ['id' => $peminjaman->id]); // Add logging

            $response = [
                'status' => 'success',
                'data' => [
                    'id' => $peminjaman->id,
                    'borrower_name' => $peminjaman->borrower_name,
                    'borrower_phone' => $peminjaman->borrower_phone,
                    'commodity' => $peminjaman->commodity,
                    'quantity' => $peminjaman->quantity,
                    'loan_date' => $peminjaman->loan_date,
                    'due_date' => $peminjaman->due_date,
                    'return_date' => $peminjaman->return_date,
                    'status' => $peminjaman->status,
                    'purpose' => $peminjaman->purpose,
                    'notes' => $peminjaman->notes,
                    'formatted_loan_date' => Carbon::parse($peminjaman->loan_date)->format('d/m/Y'),
                    'formatted_due_date' => Carbon::parse($peminjaman->due_date)->format('d/m/Y'),
                    'formatted_return_date' => $peminjaman->return_date ? Carbon::parse($peminjaman->return_date)->format('d/m/Y') : null
                ]
            ];

            Log::info('Show loan response', $response); // Add logging
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error showing loan: ' . $e->getMessage(), [
                'id' => $peminjaman->id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat data peminjaman'
            ], 500);
        }
    }

    public function returnLoan(Loan $peminjaman)
    {
        DB::beginTransaction();
        try {
            if ($peminjaman->status !== 'borrowed') {
                throw new \Exception('Barang ini sudah dikembalikan');
            }

            $peminjaman->update([
                'status' => 'returned',
                'return_date' => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Barang berhasil dikembalikan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error returning loan: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
