@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="flex-col flex justify-center">
            <div class="w-100 bg-white p-6 rounded-lg flex justify-center">
                Notifications
            </div>
            <div class="p-6">
                <form action="" method="post">
                    <input type="url" name="destination" id="destination">
                    <label for="noti-options">Choose notification triggers:</label>
                    <select name="noti-options" id="noti-options">
                        <option value="no-option" selected>None</option>
                        <option value="post-create">Post Creation</option>
                        <option value="post-like">Post Liked</option>
                    </select>
                    <input type="submit" value="Submit">
                </form>
            </div>
    
        </div>
    </div>

@endsection