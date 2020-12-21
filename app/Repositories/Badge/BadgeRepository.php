<?php


namespace App\Repositories\Badge;


use App\Models\Badge;
use App\Models\Role;
use App\Repositories\AbstractRepository;
use Illuminate\Http\Request;

class BadgeRepository extends AbstractRepository implements BadgeInterface
{
    protected $model;

    public function __construct(Badge $badge)
    {
        $this->model = $badge;
    }

    public function getBadgesAndRole($type, $id = null)
    {
        $role = Role::where('name', $type)->first();

        if ($id) {
            $badges = Badge::where('role_id', $id)->latest()->paginate(10);
            return array($badges, $role);
        }

        return $role;

    }

    public function createBadge(Request $request)
    {

    }

    public function delete($id)
    {
        $this->model->where('id', $id)->userBadges()->delete();
        return $this->model->where('id', $id)->delete();
    }
}
