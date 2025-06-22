<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdditionalQuestion;
use App\Models\Configweb;
use Illuminate\Http\Request;

class AdditionQuestionController extends Controller
{
    //
    public function show()
    {

        $additionalQuestions = AdditionalQuestion::all(); // Retrieve all records

        // Return to a view or as a JSON response
        return view('admin.additional_question.home', compact('additionalQuestions'));
    }
    public function create(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        // Nếu is_active = 1, thì reset các bản ghi khác về 0
        if ($validated['is_active'] == 1) {
            AdditionalQuestion::where('isActive', 1)->update(['isActive' => 0]);
        }

        // Tạo bản ghi mới
        AdditionalQuestion::create([
            'price' => $validated['price'],
            'isActive' => $validated['is_active'],
        ]);

        return redirect()->back()->with('success', 'Tạo giá mua thêm câu hỏi thành công!');
    }
    public function detail($id)
    {

        // Lấy thông tin kế hoạch theo id
        $additionalQuestion = AdditionalQuestion::findOrFail($id); // Lấy kế hoạch hoặc trả về lỗi 404 nếu không tìm thấy

        return view('admin.additional_question.detail', compact('additionalQuestion')); // Trả về view với dữ liệu kế hoạch
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        // Find the additional question
        $additionalQuestion = AdditionalQuestion::findOrFail($id);

        // Update values
        $additionalQuestion->price = $request->input('price');
        $additionalQuestion->isActive = $request->input('is_active');
        $additionalQuestion->save();

        return redirect()->back()->with('success', 'Giá trị đã được cập nhật thành công!');
    }

    public function delete($id)
    {
        // Lấy kế hoạch theo ID
        $additionalQuestion = AdditionalQuestion::findOrFail($id);
        $additionalQuestion->delete();

        return redirect()->back()->with('success', 'Xóa thành công gói câu hỏi thêm!');
    }
    public function updateActive($id)
    {
        // Set tất cả là 0 trước
        AdditionalQuestion::where('id', '!=', $id)->update(['isActive' => 0]);

        // Cập nhật bản ghi được chọn là 1
        $additionalQuestion = AdditionalQuestion::findOrFail($id);
        $additionalQuestion->isActive = 1;
        $additionalQuestion->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
    public function showFormCreate()
    {
        $tasks = [];

        $configWeb = ConfigWeb::where('isUse', 1)->first();

        return view('admin.additional_question.create-form', compact('configWeb', 'tasks'));
    }
}
