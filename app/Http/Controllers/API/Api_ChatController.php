<?php

namespace App\Http\Controllers\API;

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
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class Api_ChatController extends Controller
{
    /* public function rooms(Request $request)
    {
        return ChatRoom::all();
    } */
    public function rooms(Request $request)
    {
        // تجلب رقم المستخدم
        $user_id =  Auth::id();
        $user_role = User::where('id', $user_id)->pluck('role')->first();

        //تجلب كل الغرف العامة
        $publicChat = ChatRoom::where('type', 'public')->get();

        // تجلب أرقام الغرف التي يتواجد فيها المستخدم من جدول المشاركين
        $rooms = Participant::where('user_id', $user_id)->select('chat_room_id')->get();

        $roomIds = $rooms->pluck('chat_room_id')->toArray();
        //تجلب الغرف من جدول الغرف

        $privetChat = ChatRoom::whereIn('id', $roomIds)->get();
        // تدمج الغرف العامة مع الخاصة 

        // اذا كان المستخدم ادمن او سوبر ادمن اجلب له غرف الدعم الفني
        if ($user_role == 'admin' || $user_role == 'superadmin') {
            // دمج كل الغرف العامة والدعم الفني والخاصة
            $technical_support = ChatRoom::where('type', 'technical support')->get();
            $chatRooms = $publicChat->merge($technical_support);
            $allChatRooms = $chatRooms->merge($privetChat);
        } else {
            // دمج الغرف العامة مع الخاصة
            $allChatRooms = $publicChat->merge($privetChat);
        }

        //return $chatRooms;
        $response = [
            'status' => true,
            'message' => 'you get all rooms',
            'data' => $allChatRooms
        ];
        return response()->json($response, 200);
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
        // يقوم بفحص ان كان هنالك غرفة خاصة ام لا قبل انشاء واحدة جديدة
        $room_exists1 = ChatRoom::where('user1', Auth::id())->where('user2', $request->user_id)->where('type', 'privet')->first(); // ترجع مصفوفة
        $room_exists2 = ChatRoom::where('user1', $request->user_id)->where('user2', Auth::id())->where('type', 'privet')->first(); // ترجع مصفوفة

        // هنا شرط يفحص ان كان هناك غرفة خاصة موجودة مسبقا سوف يعيد رقم الغرفة
        if (!empty($room_exists1) || !empty($room_exists2)) {
            if (!empty($room_exists1)) {
                $response = [
                    'status' => true,
                    'message' => "There is an room exists",
                    'data' => [$room_exists1->id]
                ];
                return response()->json($response, 400);
            } else {
                $response = [
                    'status' => true,
                    'message' => "There is an room exists",
                    'data' => [$room_exists2->id]
                ];
                return response()->json($response, 400);
            }
        }

        $newRoom = ChatRoom::create([
            'name' => 'New Room',
            'type' => 'privet',
            'user1' => Auth::id(),
            'user2' => $request->user_id,
        ]);
        $firstParticipant = Participant::create([
            'chat_room_id' => $newRoom->id,
            'user_id' => Auth::id(),
            'role' => 'admin',
        ]);
        $secondParticipant = Participant::create([
            'chat_room_id' => $newRoom->id,
            'user_id' => $request->user_id,
            'role' => 'member',
        ]);
        $response = [
            'status' => true,
            'message' => 'you creat new chat room successfully',
            'data' => []
        ];
        return response()->json($response);
        //return response()->json();
    }

    public function startTextingTechnicalSupport(Request $request)
    {
        // عندما يضغط المستخدم على زر مراسلة مع الدعم الفني 
        $technical_support_room = ChatRoom::where('type', 'technical support')->where('user1', Auth::id())->first();
        //return response()->json($technical_support_room);
        if (!empty($technical_support_room)) {
            //return response()->json($technical_support_room);
            $response = [
                'status' => true,
                'message' => "You already have technical support room",
                'data' => [$technical_support_room->id]
            ];
            return response()->json($response, 400);
        } else {
            //return response()->json('empty');
            $newRoom = ChatRoom::create([
                'name' => 'Technical Support',
                'type' => 'technical support',
                'user1' => Auth::id(),
            ]);

            $participant = Participant::create([
                'chat_room_id' => $newRoom->id,
                'user_id' => Auth::id(),
                'role' => 'member',
            ]);
            $response = [
                'status' => true,
                'message' => "you creat new technical support room successfully",
                'data' => []
            ];
            return response()->json($response, 200);
        }
    }

    public function createRoom(Request $request)
    {
        $newRoom = ChatRoom::create([
            'name' => $request->name,
            'type' => 'group',
            'user1' => Auth::id(),
        ]);

        $firstParticipant = Participant::create([
            'chat_room_id' => $newRoom->id,
            'user_id' => Auth::id(),
            'role' => 'admin',
        ]);
        $response = [
            'status' => true,
            'message' => 'you creat new chat room successfully',
            'data' => []
        ];
        return response()->json($response, 200);
    }

    public function addParticipant(Request $request)
    {
        //! مطلوب من الفرونت
        //! user_id of new user in room ,room_id

        $existingParticipant = Participant::where('chat_room_id', $request->room_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingParticipant) {
            $response = [
                'status' => false,
                'message' => 'user already exists',
                'data' => []
            ];
            return response()->json($response, 400);
        }

        $newParticipant = Participant::create([
            'chat_room_id' => $request->room_id,
            'user_id' => $request->user_id,
            'role' => 'member',
        ]);
        $response = [
            'status' => true,
            'message' => 'added new user successfully',
            'data' => []
        ];
        return response()->json($response, 200);
    }

    public function removeParticipant(Request $request)
    {
        //! مطلوب من الفرونت
        //! room_id , user_id

        $existingParticipant = Participant::where('chat_room_id', $request->room_id)
            ->where('user_id', $request->user_id)
            ->first();

        if (!$existingParticipant) {
            $response = [
                'status' => false,
                'message' => 'user not exists',
                'data' => []
            ];
            return response()->json($response, 400);
        }

        $Participant = Participant::where('chat_room_id', $request->room_id)
            ->where('user_id', $request->user_id)->first();
        $Participant->delete();

        $response = [
            'status' => true,
            'message' => 'delete user successfully',
            'data' => []
        ];
        return response()->json($response, 200);
    }

    // هنا حصل تعديل وجعلت رقم الغرفة ياتي من خلال الريكويست
    public function messages(Request $request)
    {
        $message = ChatMessage::where('chat_room_id', $request->room_id)->with('user')->orderBy('created_at', 'DESC')->get();
        return response()->json($message);
    }

    // هنا حصل تعديل وجعلت رقم الغرفة ياتي من خلال الريكويست
    public function newMessage(Request $request)
    {
        /* if ($request->hasFile('message')) {
            return response()->json('File');
        } else {
            return response()->json("Text");
        } */


        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $newMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $request->room_id,
            'message' => $request->message,
        ]);

        if ($request->hasFile('message')) {
            $file = $request->file('message');
            $filename = rand() . time() . '_message_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/chat'), $filename);
            $newMessage->update([
                'message' => $filename,
            ]);
        } else {
            $newMessage->update([
                'message' => $request->message,
            ]);
        }
        //return response()->json($newMessage);


        $room = ChatRoom::where('id', $request->room_id)->select('type')->first();
        if ($room->type === 'public') {
            $participants = User::select('id')->get();
            foreach ($participants as $participant) {
                $newMessageRecipient = Recipient::create([
                    'user_id' => $participant->id,
                    'message_id' => $newMessage->id,
                    'chat_room_id' => $request->room_id,
                ]);
            }
        } else {
            $participants = Participant::where('chat_room_id', $request->room_id)->select('user_id')->get();
            //$message = ChatMessage::where('privet_key', $privet_key)->select('id')->first();

            foreach ($participants as $participant) {
                $newMessageRecipient = Recipient::create([
                    'user_id' => $participant->user_id,
                    'message_id' => $newMessage->id,
                    'chat_room_id' => $request->room_id,
                ]);
            }
        }

        broadcast(new NewChatMessage($newMessage, $newMessageRecipient))->toOthers();

        $response = [
            'status' => true,
            'message' => 'new message sent',
            'data' => $newMessage
        ];
        return response()->json($response, 200);
    }
    public function readAt(Request $request, $roomId)
    {
        //$user = Auth::user();
        $readMessages = Recipient::where('user_id', $request->user_id)->where('chat_room_id', $roomId)->where('read_at', null)->get();
        foreach ($readMessages as $readMessage) {
            $readMessage->read_at = now();
            $readMessage->update();
        }

        $response = [
            'status' => true,
            'message' => 'user read message',
            'data' => []
        ];
        return response()->json($response, 200);
    }
}
