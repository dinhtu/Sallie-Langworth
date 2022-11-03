<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseController implements UserInterface
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $userBuilder = $this->user->where('id', '<>', 1);
        if (isset($request['search_input'])) {
            $userBuilder = $userBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('email', $request['search_input']));
            });
        }
        $users = $userBuilder->sortable(['created_at' => 'desc', 'status' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($users)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $users = $userBuilder->paginate($newSizeLimit);
        }
        return $users;
    }

    public function destroy($id)
    {
        $userInfo = $this->user->where('id', $id)->first();
        if (!$userInfo) {
            return false;
        }
        if ($userInfo->delete()) {
            return true;
        }
        return false;
    }
    public function checkEmail($request)
    {
        return !$this->user->where(function ($query) use ($request) {
            if (isset($request['id'])) {
                $query->where('id', '!=', $request["id"]);
            }
            $query->where(['email' => $request["value"]]);
        })->exists();
    }
    public function store($request)
    {
        $this->user->type = 2;
        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->password = Hash::make($request->password);
        return $this->user->save();
    }
    public function getById($id)
    {
        return $this->user->where('id', $id)->where('id', '<>', 1)->first();
    }
    public function update($request, $id)
    {
        $userInfo = $this->user->where('id', $id)->first();
        if (!$userInfo) {
            return false;
        }
        $userInfo->name = $request->name;
        $userInfo->email = $request->email;
        if ($request->password) {
            $userInfo->password = Hash::make($request->password);
        }
        return $userInfo->save();
    }
}
