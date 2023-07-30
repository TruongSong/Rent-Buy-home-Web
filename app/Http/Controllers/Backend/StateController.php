<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\State;
use Intervention\Image\Facades\Image;


class StateController extends Controller
{
    //

    public function AllState()
    {
        $state = State::latest()->get();
        return view('backend.state.all_state', compact('state'));
    } //end method


    public function AddState()
    {

        return view('backend.state.add_state');
    } //end method 



    public function StoreState(Request $request)
    {

        $image = $request->file('state_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(370, 275)->save('upload/state/' . $name_gen);

        $save_url = 'upload/state/' . $name_gen;

        State::insert([
            'state_name' => $request->state_name,
            'state_image' =>  $save_url,

        ]);


        $notification = array(
            'message' => 'State Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.state')->with($notification);
    } //end method


    public function EditState($id)
    {

        $state = State::findOrFail($id);
        return view('backend.state.edit_state', compact('state'));
    } //end method



    public function UpdateState(Request $request)
    {

        $state_id = $request->id;
        $data = State::find($state_id);
        $img =  $data->state_image;
        if ($request->file('state_image')) {
            unlink($img);
            $image = $request->file('state_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(370, 275)->save('upload/state/' . $name_gen);

            $save_url = 'upload/state/' . $name_gen;

            State::findOrFail($state_id)->update([
                'state_name' => $request->state_name,
                'state_image' =>  $save_url,

            ]);


            $notification = array(
                'message' => 'State Updated With Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.state')->with($notification);
        } else {

            State::findOrFail($state_id)->update([
                'state_name' => $request->state_name,
               
            ]);


            $notification = array(
                'message' => 'State Updated Without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.state')->with($notification);
        }
    } //end method


    public  function DeleteState($id) {

        $state = State::findOrFail($id);
        $img = $state->state_image;
        unlink($img);
        State::findOrFail($id)->delete();

        $notification = array(
            'message' => 'State Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }//end method
}
