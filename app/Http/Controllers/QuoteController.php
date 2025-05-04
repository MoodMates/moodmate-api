<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $quotes = Quote::with('user')->paginate($request->get('per_page', 15));
        return response()->json($quotes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quote_text' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $quote = Quote::create($validated);

        return response()->json($quote, Response::HTTP_CREATED);
    }

    public function show(Quote $quote)
    {
        return response()->json($quote->load('user'));
    }

    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'quote_text' => ['sometimes', 'string', 'max:255'],
            'user_id' => ['sometimes', 'exists:users,id'],
        ]);

        $quote->update($validated);

        return response()->json($quote);
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
