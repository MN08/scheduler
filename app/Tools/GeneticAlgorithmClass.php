<?php


namespace App\Tools;

use App\Models\Days;
use App\Models\Room;
use App\Models\Time;
use App\Models\Schedule;
use App\Models\SchoolYear;
use App\Models\TeacherSubject;
use Illuminate\Support\Facades\DB;

class GeneticAlgorithmClass
{

    private $populasi = 50;
    private $crossOver = 0.70;
    private $mutasi = 0.40;
    private $log;
    private $induk = array();
    private $individu = array();

    public $teachersubjects;
    // public $subjects;
    public $times;
    public $days;
    public $schoolyears;
    public $rooms;
    public function __construct($teachersubjects, $times, $days, $schoolyears, $rooms, $populasi = 10, $maxGeneration = 10000)
    {
        $this->teachersubjects = $teachersubjects;
        $this->times = $times;
        $this->days = $days;
        // $this->subjects = $subjects;
        $this->schoolyears = $schoolyears;
        $this->rooms = $rooms;
        $this->populasi = $populasi;
        $this->maxGeneration = $maxGeneration;
    }
    // initate the data/gen
    public function init()
    {
        $this->currentGeneration = 0;
        $this->individu = [];

        $this->teacher_count = $this->teachersubjects->count();
        $this->times_count = $this->times->count();
        $this->days_count = $this->days->count();
        $this->rooms_count = $this->rooms->count();
        // $this->grade_count = $this->rooms->count();

        //build random schedule
        for ($i = 0; $i < $this->populasi; $i++) {
            foreach ($this->teachersubjects as $key => $teachersubject) {
                $this->individu[$i][$key] = [];
                $this->individu[$i][$key]['times'] = mt_rand(0, $this->times_count - $teachersubject->subject->available_time);
                $this->individu[$i][$key]['days'] = mt_rand(0, $this->days_count - 1);
                $this->individu[$i][$key]['rooms'] = mt_rand(0, $this->rooms_count - 1);
                // $this->individu[$i][$key]['grade'] = mt_rand(0, $this->rooms_count - $teachersubject->grade);
            }
        }

        return $this->individu;
    }

    //check gen fitness
    public function fitness()
    {
        $fitness = [];
        //check individu fitness
        for ($i = 0; $i < $this->populasi; $i++) {
            $fitness[$i] = $this->calculateFitness($i);
        }

        return $fitness;
    }

    //calculate fitness value
    public function calculateFitness($i)
    {
        $penalty = 0;

        foreach ($this->teachersubjects as $key_1 => $teachersubject_1) {
            $times_1 = $this->individu[$i][$key_1]['times'];
            $days_1 = $this->individu[$i][$key_1]['days'];
            $rooms_1 = $this->individu[$i][$key_1]['rooms'];
            $teacher_1 = $teachersubject_1->teacher->id;
            $available_time = $teachersubject_1->subject->available_time;
            // $class_grade = $this->rooms->grade;
            // $grade = $teachersubject_1->grade;

            foreach ($this->teachersubjects as $key_2 => $teachersubject_2) {
                $times_2 = $this->individu[$i][$key_2]['times'];
                $days_2 = $this->individu[$i][$key_2]['days'];
                $rooms_2 = $this->individu[$i][$key_2]['rooms'];
                $teacher_2 = $teachersubject_2->teacher->id;

                if ($key_1 == $key_2) {
                    continue;
                }
                // rule : cant in same time, same days, same class
                if (
                    $times_1 == $times_2
                    && $days_1 == $days_2
                    && $rooms_1 == $rooms_2
                ) {
                    $penalty += 1;
                }
                // rule : cant in same time, same days, same teacher
                if (
                    $times_1 == $times_2
                    && $days_1 == $days_2
                    && $teacher_1 == $teacher_2
                ) {
                    $penalty += 1;
                }

                // if (
                //     $grade <> $class_grade
                // ) {
                //     $penalty += 1;
                // }

                // rule : subject cant be in same time, same day, same class/
                // rule : subject with available_time >2 sparated in 2 days
                if ($available_time >= 2) {
                    if (
                        $times_1 + ($available_time - 1) == $times_2
                        && $days_1 == $days_2
                        && $rooms_1 == $rooms_2
                    ) {
                        $penalty += 1;
                    }
                    // rule : subject cant be in same time, same day, same teacher
                    if (
                        $times_1 + ($available_time - 1) == $times_2
                        && $days_1 == $days_2
                        && $teacher_1 == $teacher_2
                    ) {
                        $penalty += 1;
                    }
                }
            }
        }

        $fitness = floatval(1 / (1 + $penalty));

        return $fitness;
    }

    //select best individu value to become indukan
    public function selection($fitness)
    {
        $rank = [];
        $total = 0;

        for ($i = 0; $i < $this->populasi; $i++) {
            $rank[$i] = 1;
            $fitness_1 = floatval($fitness[$i]);

            for ($j = 0; $j < $this->populasi; $j++) {
                $fitness_2 = floatval($fitness[$j]);

                if ($fitness_1 > $fitness_2) {
                    $rank[$i] += 1;
                }
            }

            $total += $rank[$i];
        }
        //shorting fitness value
        $total_rank = count($rank);
        for ($i = 0; $i < $this->populasi; $i++) {
            $target = mt_rand(0, $total - 1);

            $check = 0;
            for ($j = 0; $j < $total_rank; $j++) {
                $check += $rank[$j];

                if ($check >= $target) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }

    //crossing the indukan data to make
    public function startCrossOver()
    {
        $new_individu = [];
        // randomly crossing the value from 2 indukan
        for ($i = 0; $i < $this->populasi; $i += 2) {
            $individu_1 = 0;

            $crossOver = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

            if ($crossOver < $this->crossOver) {
                $individu_2 = mt_rand(0, $this->teacher_count - 2);

                while ($individu_1 <= $individu_2) {
                    $individu_1 = mt_rand(0, $this->teacher_count - 1);
                }

                for ($j = 0; $j < $individu_2; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }

                for ($j = $individu_2; $j < $individu_1; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i + 1]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i]][$j];
                }

                for ($j = $individu_1; $j < $this->teacher_count; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }
            } else {
                for ($j = 0; $j < $this->teacher_count; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }
            }
        }

        for ($i = 0; $i < $this->populasi; $i += 2) {
            for ($j = 0; $j < $this->teacher_count; $j++) {
                $this->individu[$this->induk[$i]][$j] = $new_individu[$i][$j];
                $this->individu[$this->induk[$i + 1]][$j] = $new_individu[$i + 1][$j];
            }
        }
    }


    public function mutation()
    {
        $fitness = [];
        $ratio = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        $this->teacher_count = $this->teachersubjects->count();

        for ($i = 0; $i < $this->populasi; $i++) {
            if ($ratio < $this->mutasi) {
                $teacher = mt_rand(0, $this->teacher_count - 1);
                $available_time = $this->teachersubjects[$teacher]->available_time;

                $this->individu[$i][$teacher]['times'] = mt_rand(0, $this->times_count - $available_time);
                $this->individu[$i][$teacher]['days'] = mt_rand(0, $this->days_count - 1);
                $this->individu[$i][$teacher]['rooms'] = mt_rand(0, $this->rooms_count - 1);
            }

            $fitness[$i] = $this->calculateFitness($i);
        }

        return $fitness;
    }

    public function generate()
    {
        try {
            ini_set('max_execution_time', -1);

            $this->currentGeneration += 1;

            $fitness = $this->fitness();
            $this->selection($fitness);
            $this->startCrossOver();

            $fitnessAfterMutation = $this->mutation();

            $found = false;
            foreach ($fitnessAfterMutation as $key => $fitness_value) {
                if ($fitness_value == 1) {
                    $found = true;

                    $solutions = $this->individu[$key];
                    $schedules = collect();


                    foreach ($this->teachersubjects as $teacher_index => $teachersubject) {
                        $solution = $solutions[$teacher_index];
                        $time = $this->times[$solution['times']] ?? null;
                        $day = $this->days[$solution['days']] ?? null;
                        $room = $this->rooms[$solution['rooms']] ?? null;

                        if (!$time || !$day || !$room) {
                            // dump($time);
                            // dump($day);
                            // dump($room);
                            // dump($teachersubject);
                            continue;
                        }

                        // $schedules[] = [
                        //     'teacher_subject_id ' => $teachersubject->id,
                        //     'time_id' => $time->id,
                        //     'day_id' => $day->id,
                        //     'room_id' => $room->id,
                        // ];

                        $schedule = [
                            // 'teacher' => $teachersubject->teacher->name,
                            // 'room' => $room->grade . $room->code,
                            'teacher_subject_id' => $teachersubject->id,
                            'room_id' => $room->id,
                            'day_id' => $day->id,
                            'time_id' => $time->id,
                            'school_year_id' => 1,
                            // 'day' => $day->name,
                            // 'time' => $time->start_time . ' - ' . $time->end_time,
                        ];

                        $schedules->push($schedule);
                    }
                    // return $schedules->toArray();
                    $to_fill = [];
                    foreach ($schedules as $schedule) {
                        $to_fill[] = (array)$schedule;
                    }
                    DB::table('schedules')->where('school_year_id', 1)->delete();
                    DB::table('schedules')->insert($to_fill);

                    // DB::table('schedules')->delete($to_fill);

                    return true;
                    // $sorted = $schedules->sortBy(['day_id', 'asc'], ['time_id', 'asc']);

                    // for ($i = 1; $i <= 6; $i++) {
                    //     echo "<table style='width: 100%' border=1>";
                    //     foreach ($sorted->where('day_id', $i) as $key => $value) {
                    //         echo
                    //         "<tr>
                    //             <td width=100>{$value['day']}</td>
                    //             <td width=100>{$value['time']}</td>
                    //             <td width=100>{$value['room']}</td>
                    //             <td width=300>{$value['teacher']}</td>
                    //             <td>{$value['subject']}</td>
                    //         </tr>";
                    //     }
                    //     echo "</table>";
                    // }
                    // echo json_encode($sorted->values()->all());
                    exit;
                    // $time = $this->times[$solution[]]
                    break;
                }
            }

            if (!$found && $this->currentGeneration < $this->maxGeneration) {
                $this->generate();
            }
            // dd($schedules);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
