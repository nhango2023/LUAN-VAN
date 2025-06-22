<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Configweb;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    public function show()

    {
        $tasks = [];
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        $plans = Plan::all();
        return view('admin.plan.home', compact('plans', 'configWeb', 'tasks'));
    }
    public function showFormCreate()
    {
        $tasks = [];
        $configWeb = ConfigWeb::where('isUse', 1)->first();

        return view('admin.plan.create-form', compact('configWeb', 'tasks'));
    }
    // Lưu kế hoạch mới vào cơ sở dữ liệu
    public function create(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'processes' => 'required|integer',
            'questions_limit' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // Lưu kế hoạch vào cơ sở dữ liệu
        Plan::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'processes' => $validated['processes'],
            'questions_limit' => $validated['questions_limit'],
            'description' => $validated['description'],
        ]);

        // Quay lại trang danh sách với thông báo thành công
        return redirect()->route('admin.plan.show')->with('success', 'Kế hoạch đã được tạo thành công!');
    }
    public function detail($id)
    {
        Log::debug($id . '');
        // Lấy thông tin kế hoạch theo id
        $plan = Plan::findOrFail($id); // Lấy kế hoạch hoặc trả về lỗi 404 nếu không tìm thấy

        return view('admin.plan.detail', compact('plan')); // Trả về view với dữ liệu kế hoạch
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu người dùng
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'processes' => 'required|integer',
            'questions_limit' => 'required|integer',
            'duration' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        try {
            // Lấy thông tin kế hoạch theo id
            $plan = Plan::findOrFail($id);

            // Cập nhật thông tin kế hoạch
            $plan->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'processes' => $validated['processes'],
                'questions_limit' => $validated['questions_limit'],
                'duration' => $validated['duration'],
                'description' => $validated['description'],
            ]);

            // Chuyển hướng với thông báo thành công
            return back()->with('success', 'Kế hoạch đã được cập nhật thành công!');
        } catch (\Exception $e) {
            // Chuyển hướng với thông báo thất bại nếu có lỗi
            return back()->with('error', 'Cập nhật kế hoạch thất bại. Vui lòng thử lại!');
        }
    }

    public function delete($id)
    {
        // Lấy kế hoạch theo ID
        $plan = Plan::findOrFail($id);

        // Xóa kế hoạch
        $plan->delete();

        // Quay lại trang danh sách kế hoạch với thông báo thành công
        return redirect()->route('admin.plan.show')->with('success', 'Kế hoạch đã được xóa thành công!');
    }
}
