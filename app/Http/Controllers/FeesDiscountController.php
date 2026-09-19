<?php

namespace App\Http\Controllers;

use App\Http\Requests\EarlyPaymentDiscountStoreRequest;
use App\Http\Requests\FeesDiscountStoreRequest;
use App\Models\EarlyPaymentDiscount;
use App\Models\Setting;
use App\Models\SiblingFeesDiscount;
use Illuminate\Http\Request;

class FeesDiscountController extends Controller
{
    public function index(){
        $data['title']       = ___('fees.Fees Discount Setup');
        $data['fees_discount'] = SiblingFeesDiscount::all();
        $data['early_payment_discount'] = EarlyPaymentDiscount::all();
        return view('backend.fees.fees-discount.index', compact('data'));
    }

    public function store(FeesDiscountStoreRequest $request){
        try {
            SiblingFeesDiscount::truncate();

            $siblingsNumbers = $request->input('siblings_number', []);
            $discountTitles = $request->input('discount_title', []);
            $discountPercentages = $request->input('discount_percentage', []);

            foreach ($siblingsNumbers as $index => $number) {
                SiblingFeesDiscount::create([
                    'siblings_number' => $number,
                    'discount_title' => $discountTitles[$index] ?? null,
                    'discount_percentage' => $discountPercentages[$index] ?? null,
                ]);
            }

            return redirect()->back()->with('success', ___('alert.updated_successfully'));

        }catch (\Exception $e){
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function toggleApplicable(Request $request)
    {
        $request->validate([
            'value' => 'required|in:0,1'
        ]);

        try {
            Setting::where('name', 'siblings_discount_applicable')
                ->update(['value' => $request->value]);

            return response()->json(['status' => 'success', 'message' => 'Setting updated']);
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function storeEarlyPaymentDiscount(EarlyPaymentDiscountStoreRequest $request)
    {

        try {
            EarlyPaymentDiscount::truncate();

            $discountTitles = $request->input('discount_title', []);
            $discountPercentages = $request->input('discount_percentage', []);
            $startDates = $request->input('start_date', []);
            $endDates = $request->input('end_date', []);

            foreach ($discountTitles as $index => $discountTitle) {
                $start = $startDates[$index] ?? null;
                $end = $endDates[$index] ?? null;

                if ($start && $end) {
                    $overlapExists = EarlyPaymentDiscount::where(function ($query) use ($start, $end) {
                        $query->where('start_date', '<=', $end)
                            ->where('end_date', '>=', $start);
                    })->exists();


                    if ($overlapExists) {
                        return redirect()->back()->with('danger', 'Discount overlaps with another discount');
                    }
                }

                EarlyPaymentDiscount::create([
                    'name' => $discountTitle ?? null,
                    'start_date' => $start,
                    'end_date' => $end,
                    'discount_percentage' => $discountPercentages[$index] ?? null,
                ]);
            }

            return redirect()->back()->with('success', ___('alert.updated_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function toggleEarlyPayment(Request $request)
    {
        $request->validate([
            'value' => 'required|in:0,1'
        ]);

        try {
            Setting::updateOrCreate(
                ['name' => 'early_payment_discount_applicable'],
                ['value' => $request->value]
            );
            return response()->json(['status' => 'success', 'message' => 'Setting updated']);
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
