<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Gallery_image;
use App\Models\Job_file;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Api_GalleryController extends Controller
{

    public function index()
    {
        $gallery = Gallery::all();
        return response()->json($gallery);
    }

    public function createGallery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'minimized_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $gallery = Gallery::create([
            'user_id' => Auth::id(),
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
        ]);
        //return response()->json($gallery->id);

        if ($request->hasFile('minimized_picture')) {
            $file = $request->file('minimized_picture');
            $filename = rand() . time() . '_minimized_picture_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gallery'), $filename);
            $gallery->update([
                'minimized_picture' => $filename,
            ]);
        }
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/gallery'), $filename);
                Gallery_image::create([
                    'gallery_id' => $gallery->id,
                    'image' => $filename,
                ]);
            }
        }
        return response()->json('Gallery created successfully');
    }

    public function updateGallery(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        //$gallery_image = $gallery->gallery_images;

        // ان اردت استخراج ارري معين من الكوليكشن  حسب شرط معين
        /* $filteredImages = $gallery_image->filter(function ($image) {
            return $image->image === '20932269011684239426_airpod.png';
        });
        return response()->json($filteredImages);
        */

        $validator = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'minimized_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $gallery->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = rand() . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/gallery'), $filename);
                Gallery_image::create([
                    'image' => $filename,
                    'gallery_id' => $gallery->id,
                ]);
            }
        }

        $selectedCheckboxes = $request->input('deleteFile'); // id of image in table job_files
        if ($selectedCheckboxes) {
            foreach ($selectedCheckboxes as $value) {
                $idFilesDelete = Gallery_image::findOrFail($value);
                File::delete(public_path('uploads/gallery/' . $idFilesDelete->file_name));
                $idFilesDelete->delete();
            };
        }

        /* $minimizedPictureDelete = $gallery->minimized_picture;
        File::delete(public_path('uploads/gallery/' . $minimizedPictureDelete)); */

        if ($request->hasFile('minimized_picture')) {
            $minimizedPictureDelete = $gallery->minimized_picture;
            File::delete(public_path('uploads/gallery/' . $minimizedPictureDelete));
            $file = $request->file('minimized_picture');
            $filename = rand() . time() . '_minimized_picture_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gallery'), $filename);
            $gallery->update([
                'minimized_picture' => $filename,
            ]);
        }
        return response()->json('Gallery updated successfully');
    }

    public function destroyGallery(Request $request, $id)
    {
        /* $gallery = Gallery::findOrFail($id);
        $galleryImage = $gallery->gallery_images;
        $galleryImage->delete(); */
        $gallery = Gallery::findOrFail($id);
        $gallery->gallery_images()->delete();
        $gallery->delete();
        return response()->json('Gallery deleted successfully');
    }
}
