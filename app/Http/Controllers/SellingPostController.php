<?php

namespace App\Http\Controllers;

use App\Events\NotifyManagementEvent;
use App\Http\Requests\PostRequest;
use App\Models\SellingPost;
use App\Repositories\SellingPostRepository;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Attribute;
use Barryvdh\DomPDF\Facade\Pdf;

class SellingPostController extends Controller
{
    public function index(Request $request, $status = null)
    {
        $search = $request->input('search');

        if ($status === 'trash') {
            $posts = SellingPostRepository::getTrashed(10); // paginate 10 per page
        } else {
            $posts = SellingPostRepository::getByStatus($status, 10, $search);
        }
        return view('admin.sellingPosts.index', compact('posts', 'status'));
    }


    public function edit($id)
    {
        $post = SellingPost::with(['categories', 'attributes', 'thumbnails', 'profile'])
            ->findOrFail($id);

        $brands = Brand::orderBy('name')->get();

        $categories = Category::whereNull('parent_id')->get();
        $subcategories = Category::whereNotNull('parent_id')->get();

        $attributes = Attribute::orderBy('name')->get();

        return view('admin.sellingPosts.edit', compact(
            'post',
            'brands',
            'categories',
            'subcategories',
            'attributes'
        ));
    }


    public function update(PostRequest $request, $id)
    {
        $redirectStatus = $request->input('redirect_status');
        $post = SellingPostRepository::findOrFail($id);

        $data = $request->all();
        $data['thumbnail'] = $request->file('thumbnail');
        $data['additional_images'] = $request->file('additional_images');
        $data['remove_additional_images'] = $request->input('remove_additional_images', []);
        $data['existing_additional_images'] = $request->input('existing_additional_images', []);

        SellingPostRepository::updatePostWithMedia($post, $data);

        return redirect()
            ->route('posts.index', $redirectStatus)
            ->with('success', 'Post updated successfully');
    }



    public function updateStatus(Request $request, $id)
    {
        $post = SellingPostRepository::findOrFail($id);
        $post->status = $request->status;
        if ($request->status === 'Soled') {
            $post->is_sold = true;
        }
        $post->save();

        return redirect()->back()->with('success', 'Post status updated!');
    }

    public function destroy($id)
    {
        $post = SellingPostRepository::query()->findOrFail($id);
        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }


    public static function getTrashed($perPage = 10)
    {
        return SellingPost::onlyTrashed()->paginate($perPage);
    }

    // SellingPostController
    public function restore($id)
    {
        $post = SellingPost::onlyTrashed()->findOrFail($id);
        $post->restore();

        return back()->with('success', 'Post restored successfully!');
    }


    // Report Generation
    public function productReport(Request $request){
        $format = $request->query('format');
        $range = $request->query('range');

        $products = SellingPostRepository::getProductsByDateRange($range, $request);
        $dateTitle = SellingPostRepository::getDateRangeTitle($range, $request);
        $stats = SellingPostRepository::getReportStats($products);

         if ($format === 'pdf') {
            return $this->downloadPDF($products, $dateTitle, $stats);
        } else {
            return $this->downloadCSV($products, $dateTitle);
        }
    }


    private function downloadPDF($products, $dateTitle, $stats)
    {
        $pdf = Pdf::loadView('admin.reports.products-pdf', [
            'products' => $products,
            'dateTitle' => $dateTitle,
            'stats' => $stats,
            'generatedAt' => now()->format('d M Y, h:i A'),
        ]);
        $fileName = 'products-report-' . now()->format('Y-m-d-His') . '.pdf';
        return $pdf->download($fileName);
    }


    private function downloadCSV($products, $dateTitle)
    {
        $fileName = 'products-report-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // CSV
        $callback = function () use ($products, $dateTitle) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Products Report - ' . $dateTitle]);
            fputcsv($file, []);
            fputcsv($file, ['SL', 'Product Title', 'Category', 'Seller', 'Status', 'Posted Date']);

            $sl = 1;
            foreach ($products as $product) {
                fputcsv($file, [
                    $sl++,
                    $product->title ?? 'N/A',
                    $product->category->name ?? 'N/A',
                    $product->user->name ?? 'N/A',
                    $product->status ?? 'N/A',
                    $product->created_at->format('d M Y h:i A')
                ]);
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }


}
