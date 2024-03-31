<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    
    public function storeTask(TaskRequest $request)
    {
        // Validate the request data
        $validated = $request->validated();
    
        // Check if a file has been uploaded
        if ($request->hasFile('content')) {
            // Get the uploaded file
            $file = $request->file('content');
    
            // Validate file format
            $allowedFormats = ['svg', 'png', 'jpg', 'mp4', 'csv', 'txt', 'doc', 'docx'];
            $extension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($extension), $allowedFormats)) {
                return response()->json(['error' => 'Invalid file format'], Response::HTTP_BAD_REQUEST);
            }
    
            // Move the uploaded file to the storage location
            $filePath = $file->store('uploads');
    
            // Assign the file path to the content attribute
            $validated['content'] = $filePath;
        }
    
        // Create the task
        $task = Task::create($validated);
    
    
        // Return the task data
        return response()->json($task, Response::HTTP_OK);
    }





    public function showTasks(){

             // Retrieve the JSON data from the request body
             $user = auth()->user();
             
            $tasks = Task::where('user_id', $user->id)
                    ->where('completed', false) // Or ->where('completed', 0)
                    ->get();
        
             return $tasks;
        // // Retrieve tasks associated with the user's ID
        // $tasks = Task::where('user_id', $userId)->get();

        // return response()->json($tasks);
    }







    public function deleteTask($id){

        $user = auth()->user();
        $deletedTask = Task::findOrFail($id);

        if($deletedTask->user_id !== $user->id){
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $deletedTask->delete();

        return $deletedTask;
    }


    public function taskCompleted(TaskRequest $request, $id){
        $validated = $request->validated();

        $user = auth()->user();
        $task = Task::findOrFail($id);


        if($task->user_id !== $user->id){
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    
        $task->completed = intval($validated["completed"]);

        $task->save();

        return $task;
        
    }


    public function taskUpdate(TaskRequest $request, $id){


        $validated = $request->validated();


        $user = auth()->user();


        $task = Task::findOrFail($id);


    
       
     
        if($task->user_id !== $user->id){
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    
        $task->task_title = $validated["task_title"];
        $task->description = $validated["description"];
        $task->priority = $validated["priority"];
       
         // Check if a file has been uploaded
         if ($request->hasFile('content')) {
            // Get the uploaded file
            $file = $request->file('content');
    
            // Validate file format
            $allowedFormats = ['svg', 'png', 'jpg', 'mp4', 'csv', 'txt', 'doc', 'docx'];
            $extension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($extension), $allowedFormats)) {
                return response()->json(['error' => 'Invalid file format'], Response::HTTP_BAD_REQUEST);
            }
    
            // Move the uploaded file to the storage location
            $filePath = $file->store('uploads');
    
            // Assign the file path to the content attribute
            $validated['content'] = $filePath;

            $task->content = $validated["content"];

        }

        $task->update();

        return $task;

    }
}
