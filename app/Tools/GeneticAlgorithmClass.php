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
    public function __construct($teachersubjects, $times, $all_times, $days, $schoolyears, $rooms, $populasi = 10, $maxGeneration = 10000)
    {
        $this->teachersubjects = $teachersubjects;
        $this->times = $times;
        $this->all_times = $all_times;
        $this->days = $days;
        $this->schoolyears = $schoolyears;
        $this->rooms = $rooms;
        $this->populasi = $populasi;
        $this->maxGeneration = $maxGeneration;
        // $this->subjects = $subjects;
    }

    public function init()
    {
        $this->currentGeneration = 0;
        $this->individu = [];

        // $this->teacher_count = $this->teachersubjects->count();
        // $this->times_count = $this->times->count();
        // $this->days_count = $this->days->count();
        // $this->rooms_count = $this->rooms->count();

        // $this->all_times = $this->times->getRelated()->whereIsBreak(0)->get();

        $this->teacher_ids = $this->teachersubjects->pluck('id');
        $this->time_ids = $this->times->pluck('id');
        $this->day_ids = $this->days->pluck('id');
        $this->room_ids = $this->rooms->pluck('id');
        // dd($this->time_ids);

        $this->teacher_population = [];
        for ($i = 0; $i < $this->populasi; $i++) {
            $this->teacher_subject_count = 0;
            foreach ($this->teachersubjects as $key => $teachersubject) {
                $available_time = $teachersubject->subject->available_time / 2;
                // $room_ids = $this->rooms->where('grade', $teachersubject->grade)->pluck('id');


                for ($j = 0; $j < $available_time; $j++) {
                    $this->individu[$i][$this->teacher_subject_count] = [];
                    $this->individu[$i][$this->teacher_subject_count]['times'] = $this->time_ids->random();
                    $this->individu[$i][$this->teacher_subject_count]['days'] = $this->day_ids->random();
                    $this->individu[$i][$this->teacher_subject_count]['rooms'] = $this->room_ids->random();

                    $this->teacher_population[$this->teacher_subject_count] = $teachersubject;

                    $this->teacher_subject_count++;
                }
            }
        }

        return $this->individu;
    }

    public function fitness()
    {
        $fitness = [];
        for ($i = 0; $i < $this->populasi; $i++) {
            $fitness[$i] = $this->calculateFitness($i);
        }

        return $fitness;
    }

    public function calculateFitness($i)
    {
        $penalty = 0;

        for ($j = 0; $j < $this->teacher_subject_count; $j++) {
            $times_1 = $this->individu[$i][$j]['times'];
            $days_1 = $this->individu[$i][$j]['days'];
            $rooms_1 = $this->individu[$i][$j]['rooms'];
            $teacher_1 = $this->teacher_population[$j]->teacher_id;
            $subject_1 = $this->teacher_population[$j]->subject_id;

            for ($k = 0; $k < $this->teacher_subject_count; $k++) {
                $times_2 = $this->individu[$i][$k]['times'];
                $days_2 = $this->individu[$i][$k]['days'];
                $rooms_2 = $this->individu[$i][$k]['rooms'];
                $teacher_2 = $this->teacher_population[$k]->teacher_id;
                $subject_2 = $this->teacher_population[$k]->subject_id;

                if ($j == $k) {
                    continue;
                }
                if (
                    $times_1 == $times_2
                    && $days_1 == $days_2
                    && $teacher_1 == $teacher_2
                ) {
                    $penalty += 1;
                }

                if (
                    $rooms_1 == $rooms_2
                    && $days_1 == $days_2
                    && $subject_1 == $subject_2
                ) {
                    $penalty += 1;
                }


                if (
                    $times_1 == $times_2
                    && $days_1 == $days_2
                    && $rooms_1 == $rooms_2
                ) {
                    $penalty += 1;
                }
            }
        }

        $fitness = floatval(1 / (1 + $penalty));

        return $fitness;
    }

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

    public function startCrossOver()
    {
        $new_individu = [];

        for ($i = 0; $i < $this->populasi; $i += 2) {
            $individu_1 = 0;

            $crossOver = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

            if ($crossOver < $this->crossOver) {
                $individu_2 = mt_rand(0, $this->teacher_subject_count - 2);

                while ($individu_1 <= $individu_2) {
                    $individu_1 = mt_rand(0, $this->teacher_subject_count - 1);
                }

                for ($j = 0; $j < $individu_2; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }

                for ($j = $individu_2; $j < $individu_1; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i + 1]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i]][$j];
                }

                for ($j = $individu_1; $j < $this->teacher_subject_count; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }
            } else {
                for ($j = 0; $j < $this->teacher_subject_count; $j++) {
                    $new_individu[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $new_individu[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }
            }
        }

        for ($i = 0; $i < $this->populasi; $i += 2) {
            for ($j = 0; $j < $this->teacher_subject_count; $j++) {
                $this->individu[$this->induk[$i]][$j] = $new_individu[$i][$j];
                $this->individu[$this->induk[$i + 1]][$j] = $new_individu[$i + 1][$j];
            }
        }
    }

    public function mutation()
    {
        $fitness = [];
        $ratio = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

        for ($i = 0; $i < $this->populasi; $i++) {
            if ($ratio < $this->mutasi) {
                $teacher_random = mt_rand(0, $this->teacher_subject_count - 1);
                $teachersubject = $this->teacher_population[$teacher_random];

                // $room_ids = $this->rooms->where('grade', $teachersubject->grade)->pluck('id');

                $this->individu[$i][$teacher_random] = [];
                $this->individu[$i][$teacher_random]['times'] = $this->time_ids->random();
                $this->individu[$i][$teacher_random]['days'] = $this->day_ids->random();
                $this->individu[$i][$teacher_random]['rooms'] = $this->room_ids->random();
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
                    for ($x = 0; $x < $this->teacher_subject_count; $x++) {
                        $solution = $solutions[$x];

                        $time = $this->times->where('id', $solution['times'])->first();
                        $day = $this->days->where('id', $solution['days'])->first();
                        $room = $this->rooms->where('id', $solution['rooms'])->first();
                        $teachersubject = $this->teacher_population[$x] ?? null;

                        if (!$time || !$day || !$room) {
                            dump("Solutions", $solution);
                            dump("All Room", $this->rooms);
                            dump("All Time", $this->all_times);
                            dump("All Day", $this->days);
                            dump($time, $day, $room);
                            dd("ERROR");
                            continue;
                        }

                        $time_next = $this->all_times->where('sequence', $time->sequence + 1)->first();

                        $schedule = [
                            'teacher_subject_id' => $teachersubject->id,
                            'teacher_id' => $teachersubject->teacher->name,
                            'subject_id' => $teachersubject->subject->name,
                            'time_id' => $time->id,
                            'day_id' => $day->id,
                            'room' => $room->grade . $room->code,
                            'day' => $day->name,
                            'time' => $time->start_time . ' - ' . $time->end_time,
                        ];

                        $schedules->push($schedule);

                        if ($time_next) {
                            $schedule = [
                                'teacher_subject_id' => $teachersubject->id,
                                'teacher_id' => $teachersubject->teacher->name,
                                'subject_id' => $teachersubject->subject->name,
                                'time_id' => $time_next->id,
                                'day_id' => $day->id,
                                'room' => $room->grade . $room->code,
                                'day' => $day->name,
                                'time' => $time_next->start_time . ' - ' . $time_next->end_time,
                            ];
                            $schedules->push($schedule);
                        }
                    }

                    $sorted = $schedules->sortBy(['room', 'asc'], ['day_id', 'asc'], ['time_id', 'asc']);

                    for ($i = 1; $i <= 6; $i++) {
                        echo "<table style='width: 100%' border=1>";
                        foreach ($sorted->where('day_id', $i) as $key => $value) {
                            echo
                            "<tr>
                                <td width=100>{$value['day']}</td>
                                <td width=100>{$value['time']}</td>
                                <td width=100>{$value['room']}</td>
                                <td width=300>{$value['teacher_id']}</td>
                                <td>{$value['subject_id']}</td>
                            </tr>";
                        }
                        echo "</table>";
                    }
                    // echo json_encode($sorted->values()->all());
                    exit;
                    // $time = $this->times[$solution[]]
                    break;
                }
            }

            if (!$found && $this->currentGeneration < $this->maxGeneration) {
                $this->generate();
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
