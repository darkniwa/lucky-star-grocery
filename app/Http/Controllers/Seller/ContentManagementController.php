<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageContent;

class ContentManagementController extends Controller
{
    public function viewCarousel(Request $request)
    {
        $carouselContent = PageContent::where('key', 'carousel')->first();
        return view('pages.seller.content.carousel.view', compact('carouselContent'));
    }

    public function createCarousel(Request $request)
    {
        return view('pages.seller.content.carousel.create');
    }

    public function editCarousel($id)
    {
        $carouselContent = PageContent::where('key', 'carousel')->first();

        if ($carouselContent) {
            // Decode the JSON value and get the specific carousel slide
            $carouselData = json_decode($carouselContent->value, true);

            // Check if the specified index exists in the carousel array
            if (isset($carouselData[$id])) {
                $carouselSlide = $carouselData[$id];

                // Pass the carousel slide to the view for editing
                return view('pages.seller.content.carousel.edit', ['carouselSlide' => $carouselSlide, 'carouselSlideId' => $id]);
            }
        }

        // Handle the case where the specified index does not exist
        // You can redirect with an error message or perform other actions
        // For example:
        return redirect()->route('carousel.view')->with('error', 'Carousel slide not found');
    }

    public function storeCarousel(Request $request)
    {
        // Validate the incoming request data with custom error messages
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'main_title' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'primary_button_title' => 'required|string',
            'primary_button_link' => 'required|string',
            'secondary_button_title' => 'required|string',
            'secondary_button_link' => 'required|string',
        ]);

        // Retrieve the home page or adapt this logic based on your application
        $homePage = Page::where('name', 'home')->firstOrFail();

        // Upload and store the image
        $imagePath = $request->file('image')->store('uploads/page_content', 'public');

        // Create a new carousel slide
        $slide = [
            'image' => $imagePath,
            'first_line' => $validatedData['main_title'],
            'second_line' => $validatedData['title'],
            'third_line' => $validatedData['description'],
            'buttons' => [
                [
                    'text' => $validatedData['primary_button_title'],
                    'link' => $validatedData['primary_button_link'],
                ],
                [
                    'text' => $validatedData['secondary_button_title'],
                    'link' => $validatedData['secondary_button_link'],
                ],
            ],
        ];

        // Retrieve the existing carousel content or create a new one if it doesn't exist
        $carouselContent = PageContent::where('page_id', $homePage->id)
            ->where('key', 'carousel')
            ->first();

        if (!$carouselContent) {
            $carouselContent = new PageContent([
                'page_id' => $homePage->id,
                'key' => 'carousel',
                'value' => json_encode([$slide]),
            ]);
        } else {
            $carouselData = json_decode($carouselContent->value, true);
            $carouselData[] = $slide;
            $carouselContent->value = json_encode($carouselData);
        }

        $carouselContent->save();

        return redirect()->route('carousel.create')->with('success', 'Carousel slide added successfully');
    }

    public function updateCarousel(Request $request, $index)
    {
        // Validate the incoming request data with custom error messages
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'main_title' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'primary_button_title' => 'required|string',
            'primary_button_link' => 'required|string',
            'secondary_button_title' => 'required|string',
            'secondary_button_link' => 'required|string',
        ]);

        // Retrieve the home page or adapt this logic based on your application
        $homePage = Page::where('name', 'home')->firstOrFail();

        // Retrieve the existing carousel content
        $carouselContent = PageContent::where('page_id', $homePage->id)
            ->where('key', 'carousel')
            ->firstOrFail();

        $carouselData = json_decode($carouselContent->value, true);

        // Check if the specified index exists in the carousel data
        if (isset($carouselData[$index])) {
            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads/page_content', 'public');
                $carouselData[$index]['image'] = $imagePath;
            }

            // Update other fields
            $carouselData[$index]['first_line'] = $validatedData['main_title'];
            $carouselData[$index]['second_line'] = $validatedData['title'];
            $carouselData[$index]['third_line'] = $validatedData['description'];
            $carouselData[$index]['buttons'][0]['text'] = $validatedData['primary_button_title'];
            $carouselData[$index]['buttons'][0]['link'] = $validatedData['primary_button_link'];
            $carouselData[$index]['buttons'][1]['text'] = $validatedData['secondary_button_title'];
            $carouselData[$index]['buttons'][1]['link'] = $validatedData['secondary_button_link'];

            // Update the carousel content in the database
            $carouselContent->value = json_encode($carouselData);
            $carouselContent->save();

            return redirect()->route('carousel.view', ['slide' => $index])->with('success', 'Carousel slide updated successfully');
        } else {
            return redirect()->route('carousel.edit', ['slide' => $index])->with('error', 'Invalid carousel slide index');
        }
    }

    public function destroyCarousel($index)
    {
        // Retrieve the home page or adapt this logic based on your application
        $homePage = Page::where('name', 'home')->firstOrFail();

        // Retrieve the existing carousel content
        $carouselContent = PageContent::where('page_id', $homePage->id)
            ->where('key', 'carousel')
            ->firstOrFail();

        $carouselData = json_decode($carouselContent->value, true);

        // Check if the specified index exists in the carousel data
        if (isset($carouselData[$index])) {
            // Remove the slide at the specified index
            array_splice($carouselData, $index, 1);

            // Update the carousel content in the database
            $carouselContent->value = json_encode($carouselData);
            $carouselContent->save();

            return response()->json(['message' => 'Carousel slide deleted successfully']);
        } else {
            return response()->json(['error' => 'Invalid carousel slide index'], 400);
        }
    }
}
