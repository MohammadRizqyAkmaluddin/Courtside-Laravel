<?php

namespace App\Http\Controllers\Api\CSM;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Venue;
use App\Models\VenueBalance;
use App\Models\VenueBankAccount;
use App\Models\WithdrawalHistory;

use function Symfony\Component\Clock\now;

class FinanceController extends Controller
{
    public function income(Request $request)
    {
        $venueId = Auth::id();

        // optional filter (buat monthly)
        $month = $request->input('month', Carbon::now()->month);
        $year  = $request->input('year', Carbon::now()->year);

        // base query
        $baseQuery = Booking::where('venue_id', $venueId)
            ->whereDate('booking_date', '<=', now())
            ->where('status', 'Confirmed');

        // =========================
        // 🔥 TOTAL INCOME
        // =========================
        $grossIncome = (clone $baseQuery)->sum('total_price');
        $netIncome = ($grossIncome * 0.05);

        // =========================
        // 🔥 WEEKLY (7 hari terakhir)
        // =========================
        $weeklyIncome = (clone $baseQuery)
            ->whereBetween('booking_date', [
                Carbon::now()->subDays(7),
                Carbon::now()
            ])
            ->sum('total_price');

        // =========================
        // 🔥 MONTHLY (by filter)
        // =========================
        $monthlyIncome = (clone $baseQuery)
            ->whereYear('booking_date', $year)
            ->whereMonth('booking_date', $month)
            ->sum('total_price');

        // =========================
        // 🔥 YEARLY
        // =========================
        $yearlyIncome = (clone $baseQuery)
            ->whereYear('booking_date', Carbon::now()->year)
            ->sum('total_price');

        // =========================
        // 🔥 AVERAGE DAILY
        // =========================
        $dailyData = (clone $baseQuery)
            ->selectRaw('DATE(booking_date) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->get();

        $avgDaily = $dailyData->count() > 0
            ? $dailyData->avg('total')
            : 0;

        // =========================
        // 🔥 AVERAGE MONTHLY
        // =========================
        $monthlyData = (clone $baseQuery)
            ->selectRaw('YEAR(booking_date) as year, MONTH(booking_date) as month, SUM(total_price) as total')
            ->groupBy('year', 'month')
            ->get();

        $avgMonthly = $monthlyData->count() > 0
            ? $monthlyData->avg('total')
            : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'gross_income'   => $grossIncome,
                'net_income'     => $netIncome,
                'weekly_income'  => $weeklyIncome,
                'monthly_income' => $monthlyIncome,
                'yearly_income'  => $yearlyIncome,
                'avg_daily'      => round($avgDaily, 2),
                'avg_monthly'    => round($avgMonthly, 2),
                'filter' => [
                    'month' => $month,
                    'year'  => $year
                ]
            ]
        ]);
    }

    public function changeBankAccount(Request $request)
    {
        VenueBankAccount::where('venue_id', Auth::id())
                ->where('status', 'Main')
                ->update(['status' => 'Other']);

        $data = VenueBankAccount::where('id', $request->venue_bank_account_id)
            ->update(['status' => 'Main']);

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function balance()
    {
        $data = VenueBalance::where('venue_id', Auth::id())->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function mainBankAccount()
    {
        $data = VenueBankAccount::where('venue_id', Auth::id())
            ->where('status', 'Main')->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function bankAccount()
    {
        $data = VenueBankAccount::where('venue_id', Auth::id())->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function withdraw(Request $request)
    {
        $balance = VenueBalance::where('venue_id', Auth::id())->first();
        $bank = VenueBankAccount::where('venue_id', Auth::id())->where('status', 'Main')->first();


        if (!$balance) {
            return response()->json([
                'success' => false,
                'message' => 'Balance not found'
            ], 404);
        }

        $request->validate(['amount' => 'required|integer|min:10000']);

        if ($request->amount > $balance->balance) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance amount'
            ], 400);
        }

        $withdraw = WithdrawalHistory::create([
                    'venue_id' => Auth::id(),
                    'venue_bank_account_id' => $bank->id,
                    'reference_id'  => $this->generateReferenceId(),
                    'amount'   => $request->amount,
                    'status'   => 'Pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        return response()->json([
            'success' => true,
            'data'  => $withdraw
        ]);
    }

    public function pendingExists()
    {
        $data = WithdrawalHistory::with('bank')
                ->where('venue_id', Auth::id())
                ->where('status', 'Pending')
                ->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function cancelRequest()
    {
       WithdrawalHistory::where('venue_id', Auth::id())
        ->where('status', 'Pending')
        ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Request Deleted'
        ]);
    }

    private function generateReferenceId()
    {
        do {
            $ref = sprintf(
                '%04d-%04d-%04d',
                rand(0, 9999),
                rand(0, 9999),
                rand(0, 9999)
            );
        } while (
            DB::table('withdrawal_histories')
                ->where('reference_id', $ref)
                ->exists()
        );

        return $ref;
    }

    public function addBankAccount(Request $request)
    {
        VenueBankAccount::where('venue_id', Auth::id())
        ->where('status', 'Main')
        ->update(['status' => 'Other']);

        $newAccount = VenueBankAccount::create([
            'venue_id'  => Auth::id(),
            'bank_account'  => $request->account_number,
            'bank_type' => $request->bank_type,
            'status'    => 'Main'
        ]);

        return response()->json([
            'success' => true,
            'data' => $newAccount
        ]);
    }


    public function indexWithdraw(Request $request)
    {
        $perpage = $request->get('per_page', 3);

        $query = WithdrawalHistory::where('venue_id', Auth::id())
            ->with('bank')
            ->orderBy('created_at', 'desc');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
        }

        $data = $query->paginate($perpage);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getMonthlyIncome(Request $request)
    {
        $year = $request->year ?? date('Y');

        $data = Booking::where('venue_id', Auth::id())
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $result = [];

        for ($i = 1; $i <= 12; $i++) {
            $result[] = [
                'month' => $i,
                'total' => (int) ($data[$i] ?? 0)
            ];
        }

        return response()->json([
            'year' => (int) $year,
            'data' => $result
        ]);
    }

    public function courtIncomeBreakdown()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $data = DB::table('bookings')
            ->join('courts', 'bookings.court_id', '=', 'courts.id')
            ->select(
                'courts.id as court_id',
                'courts.name as court_name',
                DB::raw('COUNT(bookings.id) as total_bookings'),
                DB::raw('SUM(bookings.price) as total_income')
            )
            ->where('bookings.venue_id', Auth::id())
            ->whereBetween('bookings.created_at', [$startOfMonth, $endOfMonth])
            ->where('bookings.status', 'Confirmed')
            ->whereDate('bookings.booking_date', '<=', now())
            ->groupBy('courts.id', 'courts.name')
            ->orderByDesc('total_income')
            ->get();

        $totalIncome = $data->sum('total_income');

       return response()->json([
            'success' => true,
            'data' => [
                'total_income' => $totalIncome,
                'courts' => $data
            ]
        ]);
    }

    public function overallProductIncome()
    {
        $data = DB::table('transaction_items as ti')
            ->join('store_transactions as st', 'st.id', '=', 'ti.store_transaction_id')
            ->join('store_products as sp', 'sp.id', '=', 'ti.store_product_id')
            ->where('st.venue_id', Auth::id())

            ->select(
                'sp.id',
                'sp.name',
                'sp.product_type',

                DB::raw('CAST(SUM(ti.quantity) AS UNSIGNED) as total_qty'),
                DB::raw('CAST(SUM(ti.subtotal) AS UNSIGNED) as total_income'),

                DB::raw('CAST(SUM(sp.cogs * ti.quantity) AS UNSIGNED) as total_cogs'),
                DB::raw('CAST(SUM(ti.subtotal - (sp.cogs * ti.quantity)) AS SIGNED) as total_margin')
            )

            ->groupBy('sp.id', 'sp.name', 'sp.product_type')
            ->havingRaw('SUM(ti.quantity) > 0')
            ->orderByDesc('total_income')
            ->get();

        // 🔥 SUMMARY PER CATEGORY
        $totalMarginGear = $data->where('product_type', 'Gear')->sum('total_margin');
        $totalMarginFnb = $data->where('product_type', 'Fnb')->sum('total_margin');
        $totalMargin = $totalMarginGear + $totalMarginFnb;

        // 🔥 NEW TOTALS
        $totalSoldItem = $data->sum('total_qty');
        $totalGrossIncome = $data->sum('total_income');

        return response()->json([
            'success' => true,
            'data' => [
                'total_margin' => $totalMargin,
                'total_margin_gear' => $totalMarginGear,
                'total_margin_fnb' => $totalMarginFnb,

                // ✅ NEW
                'total_sold_item' => $totalSoldItem,
                'total_gross_income' => $totalGrossIncome,

                'income' => $data,
            ]
        ]);
    }
}
