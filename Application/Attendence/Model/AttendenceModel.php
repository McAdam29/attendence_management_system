<?php
namespace Application\Attendence\Model;

use Application\CoreModule\Model\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendenceModel extends CoreModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendence';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'attendance_date',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\AttendenceModelFactory::new();
    }
}