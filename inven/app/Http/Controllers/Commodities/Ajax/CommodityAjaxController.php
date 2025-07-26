<?php

namespace App\Http\Controllers\Commodities\Ajax;

use App\Commodity;
use App\CommodityLocation;
use App\Http\Controllers\Controller;
use App\SchoolOperationalAssistance;
use Illuminate\Http\Request;

class CommodityAjaxController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'item_code' => 'required|unique:commodities,item_code',
        'name' => 'required',
        'brand' => 'nullable|string',
        'material' => 'nullable|string',
        'year_of_purchase' => 'required|integer',
        'condition' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'price_per_item' => 'required|numeric|min:0',
        'note' => 'nullable|string',
        'school_operational_assistance_id' => 'required|exists:school_operational_assistances,id',
        'commodity_location_id' => 'required|exists:commodity_locations,id',
    ]);

    // **Check if a commodity with the same item_code already exists**
    $existingCommodity = Commodity::where('item_code', $request->item_code)->first();
    if ($existingCommodity) {
        return response()->json(['status' => 409, 'message' => 'Commodity with this Item Code already exists'], 409);
    }

    // **If not found, create a new commodity**
    $commodity = Commodity::create([
        'school_operational_assistance_id' => $request->school_operational_assistance_id,
        'commodity_location_id' => $request->commodity_location_id,
        'item_code' => $request->item_code,
        'name' => $request->name,
        'brand' => $request->brand,
        'material' => $request->material,
        'year_of_purchase' => $request->year_of_purchase,
        'condition' => $request->condition,
        'quantity' => $request->quantity,
        'price' => $request->price,
        'price_per_item' => $request->price_per_item,
        'note' => $request->note
    ]);

    return response()->json(['status' => 200, 'message' => 'Success', 'data' => $commodity], 200);
}


    public function show($id)
    {
        $commodity = Commodity::findOrFail($id);

        $data = [
            'school_operational_assistance_id' => $commodity->school_operational_assistance->name,
            'commodity_location_id' => $commodity->commodity_location->name,
            'item_code' => $commodity->item_code,
            'name' => $commodity->name,
            'brand' => $commodity->brand,
            'material' => $commodity->material,
            // $commodity->date_of_purchase
            'year_of_purchase' => $commodity->year_of_purchase,
            'condition' => $commodity->condition,
            'quantity' => $commodity->quantity,
            'price' => $commodity->indonesian_currency($commodity->price),
            'price_per_item' => $commodity->indonesian_currency($commodity->price_per_item),
            'note' => $commodity->note,
        ];

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => $data], 200);
    }

    public function edit($id)
    {
        $commodity = Commodity::findOrFail($id);

        $commodity = [
            'school_operational_assistance_id' => $commodity->school_operational_assistance_id,
            'commodity_location_id' => $commodity->commodity_location_id,
            'item_code' => $commodity->item_code,
            'name' => $commodity->name,
            'brand' => $commodity->brand,
            'material' => $commodity->material,
            'year_of_purchase' => $commodity->year_of_purchase,
            'condition' => $commodity->condition,
            'quantity' => $commodity->quantity,
            'price' => $commodity->price,
            'price_per_item' => $commodity->price_per_item,
            'note' => $commodity->note,
        ];

        return response()->json(['status' => 200, 'message' => 'Success', 'data' => [
            'commodity' => $commodity,
            'school_operational_assistances' => SchoolOperationalAssistance::all(),
            'commodity_locations' => CommodityLocation::all(),
            'conditions' => [
                'Baik',
                'Kurang Baik',
                'Rusak Berat'
            ]
        ]], 200);
    }

    public function update(Request $request, $id)
    {
        $commodities = Commodity::findOrFail($id);

        $commodities->school_operational_assistance_id = $request->school_operational_assistance_id;
        $commodities->commodity_location_id = $request->commodity_location_id;
        $commodities->item_code = $request->item_code;
        $commodities->name = $request->name;
        $commodities->brand = $request->brand;
        $commodities->material = $request->material;
        $commodities->year_of_purchase = $request->year_of_purchase;
        $commodities->condition = $request->condition;
        $commodities->quantity = $request->quantity;
        $commodities->price = $request->price;
        $commodities->price_per_item = $request->price_per_item;
        $commodities->note = $request->note;
        $commodities->save();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }

    public function destroy($id)
    {
        Commodity::findOrFail($id)->delete();

        return response()->json(['status' => 200, 'message' => 'Success'], 200);
    }
}
