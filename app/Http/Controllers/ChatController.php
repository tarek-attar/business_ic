<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;
use App\Models\Notification;
use App\Models\Participant;
use App\Models\Recipient;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /* public function rooms(Request $request)
    {
        return ChatRoom::all();
    } */
    public function rooms(Request $request)
    {
        $user =  Auth::id();
        $publicChat = ChatRoom::where('type', 'public')->get();

        $rooms = Participant::where('user_id', $user)->select('chat_room_id')->get();
        $roomIds = $rooms->pluck('chat_room_id')->toArray(); // Get an array of chat room IDs
        $privetChat = ChatRoom::whereIn('id', $roomIds)->get(); // Retrieve the corresponding ChatRoom models


        $chatRooms = $publicChat->merge($privetChat);

        return $chatRooms;
    }
    /* public function rooms(Request $request)
    {
        $user = Auth::id();
        //$user = 2;
        $publicChat = ChatRoom::where('type', 'public')->get();
        $privetChat = ChatRoom::where('user1', $user)->orWhere('user2', $user)->get();
        //$chatRooms = array_merge($publicChat, $privetChat);
        $chatRooms = $publicChat->merge($privetChat);
        //dd($chatRooms);
        return $chatRooms;
    } */

    public function startTexting(Request $request)
    {
        //! مطلوب من الفرونت
        //!  sender , receiver
        //TODO اذا تخطيت مشكلة اووث يوزر ممكن استغني عن  user_id

        $privet_key =  Auth::id() . rand() . time() . 'key';

        $$newRoom = new ChatRoom;
        $newRoom->name = 'New Room';
        $newRoom->type = 'privet';
        $newRoom->privet_key = $privet_key;
        $newRoom->save();

        $userRoom = ChatRoom::where('privet_key', $privet_key)->first();

        if ($userRoom->id) {
            $newParticipant = new Participant;
            $newParticipant->chat_room_id = $userRoom->id;
            $newParticipant->user_id = $request->sender;
            $newParticipant->role = 'admin';
            $newParticipant->save();

            $newParticipant = new Participant;
            $newParticipant->chat_room_id = $userRoom->id;
            $newParticipant->user_id = $request->receiver;
            $newParticipant->role = 'member';
            $newParticipant->save();
        }

        return 'you creat new chat room';
    }

    public function createRoom(Request $request)
    {
        //! مطلوب من الفرونت
        //! name , user_id
        //TODO اذا تخطيت مشكلة اووث يوزر ممكن استغني عن  user_id

        $privet_key =  Auth::id() . rand() . time() . 'key';

        $newRoom = new ChatRoom;
        $newRoom->name = $request->name;
        $newRoom->type = 'privet';
        $newRoom->privet_key = $privet_key;
        $newRoom->save();

        $userRoom = ChatRoom::where('privet_key', $privet_key)->first();

        if ($userRoom->id) {
            $newParticipant = new Participant;
            $newParticipant->chat_room_id = $userRoom->id;
            $newParticipant->user_id = $request->user_id;
            $newParticipant->role = 'admin';
            $newParticipant->save();
        }

        return 'you creat new chat room';
    }

    public function addParticipant(Request $request)
    {
        //! مطلوب من الفرونت
        //! user_code ,room_id

        $user = User::where('user_code', $request->user_code)->first();

        $newParticipant = new Participant;
        $newParticipant->chat_room_id = $request->room_id;
        $newParticipant->user_id = $user->id;
        $newParticipant->role = 'member';
        $newParticipant->save();

        return $newParticipant;
    }

    public function removeParticipant(Request $request)
    {
        //! مطلوب من الفرونت
        //! room_id , user_id

        $user = Participant::where('chat_room_id', $request->room_id)->where('user_id', $request->user_id)->first();
        $user->delete();

        /* $deleteUser = Participant::find($request->user_id);
        $deleteUser->delete(); */
        return 'delete done ';
    }



    public function messages(Request $request, $roomId)
    {
        return ChatMessage::where('chat_room_id', $roomId)->with('user')->orderBy('created_at', 'DESC')->get();
    }

    public function newMessage(Request $request, $roomId)
    {
        $privet_key =  Auth::id() . rand() . time() . rand() . 'key';

        $newMessage = new ChatMessage;
        $newMessage->user_id =  Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->privet_key = $privet_key;
        $newMessage->save();

        $room = ChatRoom::where('id', $roomId)->select('type')->first();
        if ($room->type === 'public') {
            $participants = User::select('id')->get();
            $message = ChatMessage::where('privet_key', $privet_key)->select('id')->first();
            foreach ($participants as $participant) {
                $newMessageRecipient = new Recipient;
                $newMessageRecipient->user_id =  $participant->id;
                $newMessageRecipient->message_id = $message->id;
                $newMessageRecipient->chat_room_id = $roomId;
                $newMessageRecipient->save();
            }
        } else {
            $participants = Participant::where('chat_room_id', $roomId)->select('user_id')->get();
            $message = ChatMessage::where('privet_key', $privet_key)->select('id')->first();

            foreach ($participants as $participant) {
                $newMessageRecipient = new Recipient;
                $newMessageRecipient->user_id =  $participant->user_id;
                $newMessageRecipient->message_id = $message->id;
                $newMessageRecipient->chat_room_id = $roomId;
                $newMessageRecipient->save();
            }
        }


        broadcast(new NewChatMessage($newMessage, $newMessageRecipient))->toOthers();

        /* $message = $newMessage;
        $user = User::where('id', Auth::id())->get();
        $chat_room = ChatRoom::where('id', $roomId)->get(); */

        /* $newMessageNotification = new Notification;
        $newMessageNotification->user_id = Auth::id();
        $newMessageNotification->chat_room_id = $roomId;
        $newMessageNotification->message = $request->message; */

        //$newMessage->user->notify(new NewMessageNotification($message, $user, $chat_room))->toOthers();

        return $newMessage; //! لا تظهر مشكلة عدم الظهور للمرسل
        //return [$newMessage, $newMessageRecipient]; //! هنا تظهر مشكلة عدم الظهور للمرسل

        /* ChatMessage::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $roomId,
        ]); */
    }
    public function readAt(Request $request, $roomId)
    {
        //$user = Auth::user();
        $readMessages = Recipient::where('user_id', $request->user_id)->where('chat_room_id', $roomId)->where('read_at', null)->get();
        foreach ($readMessages as $readMessage) {
            $readMessage->read_at = now();
            $readMessage->update();
        }

        //return 'message update';
        return 'user read message';
        //return $readMessages;
    }
}
