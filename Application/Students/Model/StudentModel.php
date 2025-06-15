<?php
namespace Application\Students\Model;
use Application\CoreModule\Model\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * StudentModel class represents the student entity in the application.
 *
 * @package Application\Students\Model
 * @author Your Name
 * @version 1.0
 * @since 2025-06-15
 */
class StudentModel extends CoreModel
{

    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_name',
        'department',
        'enrollment_date',
        'roll_no',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\StudentModelFactory::new();
    }

}