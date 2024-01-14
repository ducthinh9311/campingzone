<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\News;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $month;

    protected $year;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var News
     */
    protected $news;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var OrderDetail
     */
    protected $order_detail;

    /**
     * DashboardController constructor.
     * @param Customer $customer
     * @param News $news
     * @param Product $product
     * @param Order $order
     * @param OrderDetail $order_detail
     */
    public function __construct(Customer $customer, News $news, Product $product, Order $order, OrderDetail $order_detail)
    {
        $this->product = $product;
        $this->customer = $customer;
        $this->news = $news;
        $this->order = $order;
        $this->order_detail = $order_detail;
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;
        $this->day = Carbon::now()->day;
    }

    /**
     * Get dashboard
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $timeStatistics = $request->statistic ?? 'day';
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            $startDate = \Carbon\Carbon::parse($startDate);
            $endDate = \Carbon\Carbon::parse($endDate);
        } else {
            // Mặc định là 7 ngày gần đây nếu không có start_date và end_date được cung cấp
            $endDate = now();
            $startDate = now()->subDays(6); // 6 ngày trước
        }

        if ($timeStatistics == 'day') {
            $card = [
                'product' => $this->product->select(['id'])->get()->count(),
                'customer' => $this->customer->select(['id'])->get()->count(),
                'orderTotal' => $this->order->whereBetween('created_at', [$startDate, $endDate])->select(['id'])->get()->count(),
                'orderProcess' => $this->order->whereBetween('created_at', [$startDate, $endDate])->whereActive('processing')->select(['id'])->get()->count(),
                'order' => $this->order->whereBetween('created_at', [$startDate, $endDate])->whereActive('pending')->select(['id'])->get()->count(),
                'news' => $this->news->select(['id'])->get()->count(),
            ];

            // Order information
            $orders = $this->cardOrderDay($startDate->day, $startDate->month, $startDate->year);

            // Order chart in current year
            $chart = [
                'pending' => $this->generateChartForLast10Days('pending', $startDate, $endDate),
                'processing' => $this->generateChartForLast10Days('processing', $startDate, $endDate),
                'cancel' => $this->generateChartForLast10Days('cancel', $startDate, $endDate),
                'done' => $this->generateChartForLast10Days('done', $startDate, $endDate),
                'fail' => $this->generateChartForLast10Days('fail', $startDate, $endDate),
            ];

            return view('admin.home')->with([
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'card' => $card,
                'orders' => $orders,
                'chart' => $chart,
                'newestOrders' => $this->order->whereActive('pending')->take(10)->get()
            ]);
        } else {
            $card = [
                'product' => $this->product->select(['id'])->get()->count(),
                'customer' => $this->customer->select(['id'])->get()->count(),
                'orderTotal' => $this->order->whereMonth('created_at', $startDate->month)->whereYear('created_at', $startDate->year)->select(['id'])->get()->count(),
                'orderProcess' => $this->order->whereMonth('created_at', $startDate->month)->whereYear('created_at', $startDate->year)->whereActive('processing')->select(['id'])->get()->count(),
                'order' => $this->order->whereMonth('created_at', $startDate->month)->whereYear('created_at', $startDate->year)->whereActive('pending')->select(['id'])->get()->count(),
                'news' => $this->news->select(['id'])->get()->count(),
            ];

            // Order information
            $orders = $this->cardOrder($startDate->month, $startDate->year);

            // Order chart in current year
            $chart = [
                'pending' => $this->genChart('pending', $startDate->year),
                'processing' => $this->genChart('processing', $startDate->year),
                'cancel' => $this->genChart('cancel', $startDate->year),
                'done' => $this->genChart('done', $startDate->year),
                'fail' => $this->genChart('fail', $startDate->year),
            ];

            return view('admin.home')->with([
                'card' => $card,
                'orders' => $orders,
                'chart' => $chart,
                'newestOrders' => $this->order->whereActive('pending')->take(10)->get()
            ]);
        }
    }

    /**
     * Card order information
     *
     * @param $month
     * @param $year
     * @return array
     */
    public function cardOrder($month, $year)
    {
        $done = $this->order->whereActive('done')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        $dateS = Carbon::now()->startOfMonth()->subMonth(1);
        $dateE = Carbon::now()->startOfMonth();

        $lastSuccess = $this->order->whereActive('done')->whereBetween('created_at',[$dateS,$dateE])->get();

        $pending = $this->order->whereActive('pending')->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        $processing = $this->order->whereActive('processing')->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        $fail = $this->order->whereActive('fail')->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        $cancel = $this->order->whereActive('cancel')->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        $orderSuccess = $done->count();
        $lastOrderSuccess = $lastSuccess->count();

        $orderUp = $orderSuccess - $lastOrderSuccess;

        $currentRevenue = $this->revenue($done);
        $lastRevenue = $this->revenue($lastSuccess);

        return [
            'revenue' => $currentRevenue,
            'revenueLast' => $lastRevenue,
            'revenueUpOrDown' => $currentRevenue - $lastRevenue,
            'done' => $orderSuccess,
            'pending' => $pending,
            'processing' => $processing,
            'cancel' => $cancel,
            'fail' => $fail,
            'orderUp' => $orderUp
        ];
    }
    
    public function cardOrderDay($day,$year, $month)
    {
        $done = $this->order->whereActive('done')
            ->whereDay('created_at', $day)
            // ->whereMonth('created_at', $month)
            // ->whereYear('created_at', $year)
            ->get();
        $dateS = Carbon::now()->startOfDay()->subDay(1);
        $dateE = Carbon::now()->startOfDay();
        
        $lastSuccess = $this->order->whereActive('done')->whereBetween('created_at',[$dateS,$dateE])->get();

        $pending = $this->order->whereActive('pending')->whereDay('created_at', $day)->whereMonth('created_at', $month)
            ->count();

        $processing = $this->order->whereActive('processing')->whereDay('created_at', $day)->whereMonth('created_at', $month)
            ->count();

        $fail = $this->order->whereActive('fail')->whereDay('created_at', $day)->whereMonth('created_at', $month)
            ->count();

        $cancel = $this->order->whereActive('cancel')->whereDay('created_at', $day)->whereMonth('created_at', $month)
            ->count();

        $orderSuccess = $done->count();
        $lastOrderSuccess = $lastSuccess->count();

        $orderUp = $orderSuccess - $lastOrderSuccess;

        $currentRevenue = $this->revenue($done);
        $lastRevenue = $this->revenue($lastSuccess);

        return [
            'revenue' => $currentRevenue,
            'revenueLast' => $lastRevenue,
            'revenueUpOrDown' => $currentRevenue - $lastRevenue,
            'done' => $orderSuccess,
            'pending' => $pending,
            'processing' => $processing,
            'cancel' => $cancel,
            'fail' => $fail,
            'orderUp' => $orderUp
        ];
    }
    /**
     * Calculator revenue
     *
     * @param $order
     * @return float|int
     */
    public function revenue($order)
    {
        $total = 0;
        foreach ($order as $item) {
            $orderDetails = $this->order_detail->whereOrderId($item->id)->get();
            $revenue = 0;
            foreach ($orderDetails as $key) {
                $revenue += (($key->qty * $key->price) - ($key->qty * $key->product->unit_price));
            }
            $total += $revenue;
        }
        return $total;
    }

    /**
     * Generate value order in current year.
     *
     * @param $status
     * @param $year
     * @return string
     */
    public function genChart($status, $year)
    {
        $data = [];
        for ($id = 1; $id <= 12; $id++) {
            $order = $this->order->whereActive($status)
                ->whereMonth('created_at', $id)
                ->whereYear('created_at', $year)
                ->count();
            array_push($data, $order);
        }
        return implode(',', $data);
    }

    public function generateChartForLast10Days($status)
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(9); // Lấy dữ liệu cho 10 ngày gần nhất
    
        $data = [];
        $labels = [];
    
        // Lặp qua từng ngày trong khoảng thời gian
        while ($startDate <= $endDate) {
            $date = $startDate->toDateString();
            $count = DB::table('orders')
                ->where('active', $status)
                ->whereDate('created_at', $date)
                ->count();
    
            $labels[] = $date;
            $data[] = $count;
    
            $startDate->addDay(); // Di chuyển đến ngày tiếp theo
        }
    
        // Đảm bảo rằng mảng có đủ 10 giá trị, nếu không có dữ liệu cho một số ngày, thì gán giá trị 0 cho chúng
        $missingDays = 10 - count($data);
        for ($i = 0; $i < $missingDays; $i++) {
            $labels[] = $endDate->copy()->subDays($missingDays - $i)->toDateString();
            $data[] = 0;
        }
    
      
         return implode(', ', $data);
    }

}
