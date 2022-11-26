<?php
public function index(Request $request)
    {
        $query = Product::query();

        if ($request->product_quantity && $request->product_quantity === 'in_stock') {
            $query = $query->where('product_quantity', '>', 0);
        }
        if ($request->category_id && $request->category_id !== "0") {
            $query = $query->where('category_id', '=', $request->category_id);
        }

        $sort_field = $request->get('sort_field');
        $sort_direction = $request->get('sort_direction');
        return ProductResource::collection($query->orderBy($sort_field, $sort_direction)->get());
    }
