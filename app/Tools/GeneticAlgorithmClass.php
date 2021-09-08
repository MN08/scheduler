<?php


namespace App\Tools;

use App\Models\Time;
use App\Models\Days;
use App\Models\Room;
use App\Models\SchoolYear;
use App\Models\TeacherSubject;
use App\Models\Schedule;

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

    public function init()
    {
        $this->currentGeneration = 0;
        $this->individu = [];

        $this->teacher_count = $this->teachersubjects->count();
        $this->times_count = $this->times->count();
        $this->days_count = $this->days->count();
        $this->rooms_count = $this->rooms->count();

        for ($i = 0; $i < $this->populasi; $i++) {
            foreach ($this->teachersubjects as $key => $teachersubject) {
                $this->individu[$i][$key] = [];
                $this->individu[$i][$key]['times'] = mt_rand(0, $this->times_count - $teachersubject->subject->available_time);
                $this->individu[$i][$key]['days'] = mt_rand(0, $this->days_count - 1);
                $this->individu[$i][$key]['rooms'] = mt_rand(0, $this->rooms_count - 1);
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

        foreach ($this->teachersubjects as $key_1 => $teachersubject_1) {
            $times_1 = $this->individu[$i][$key_1]['times'];
            $days_1 = $this->individu[$i][$key_1]['days'];
            $rooms_1 = $this->individu[$i][$key_1]['rooms'];
            $teacher_1 = $teachersubject_1->teacher->id;
            $available_time = $teachersubject_1->subject->available_time;

            foreach ($this->teachersubjects as $key_2 => $teachersubject_2) {
                $times_2 = $this->individu[$i][$key_2]['times'];
                $days_2 = $this->individu[$i][$key_2]['days'];
                $rooms_2 = $this->individu[$i][$key_2]['rooms'];
                $teacher_2 = $teachersubject_2->teacher->id;

                if ($key_1 == $key_2) {
                    continue;
                }

                if (
                    $times_1 == $times_2
                    && $days_1 == $days_2
                    && $rooms_1 == $rooms_2
                ) {
                    $penalty += 1;
                }

                if (
                    $times_1 == $times_2
                    && $days_1 == $days_2
                    && $teacher_1 == $teacher_2
                ) {
                    $penalty += 1;
                }

                if ($available_time >= 2) {
                    if (
                        $times_1 + ($available_time - 1) == $times_2
                        && $days_1 == $days_2
                        && $rooms_1 == $rooms_2
                    ) {
                        $penalty += 1;
                    }

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
                            dump($time);
                            dump($day);
                            dump($room);
                            dump($teachersubject);
                            continue;
                        }

                        // $schedules[] = [
                        //     'teacher_subject_id ' => $teachersubject->id,
                        //     'time_id' => $time->id,
                        //     'day_id' => $day->id,
                        //     'room_id' => $room->id,
                        // ];

                        $schedule = [
                            'teacher' => $teachersubject->teacher->name,
                            'subject' => $teachersubject->subject->name,
                            'room' => $room->grade . $room->code,
                            'day_id' => $day->id,
                            'day' => $day->name,
                            'time_id' => $time->id,
                            'time' => $time->start_time . ' - ' . $time->end_time,
                        ];

                        $schedules->push($schedule);
                    }

                    $sorted = $schedules->sortBy(['day_id', 'asc'], ['time_id', 'asc']);

                    for ($i = 1; $i <= 6; $i++) {
                        echo "<table style='width: 100%' border=1>";
                        foreach ($sorted->where('day_id', $i) as $key => $value) {
                            echo
                            "<tr>
                                <td width=100>{$value['day']}</td>
                                <td width=100>{$value['time']}</td>
                                <td width=100>{$value['room']}</td>
                                <td width=300>{$value['teacher']}</td>
                                <td>{$value['subject']}</td>
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

    public function getData()
    {
        $i = 0;
        foreach ($this->teachersubjects as $teachersubject) {
            $teacherSubject = $teachersubject->id;
            $teacherName    = $teachersubject->teacher->id;
            $subjectName    = $teachersubject->subject->id;
            $subjectType    = $teachersubject->subject->type;
            $subjectAvailableTime = $teachersubject->subject->available_time;
            $grade          = $teachersubject->grade;
            echo $teacherSubject . "<br>" . $teacherName . " " . $subjectName . " " . $subjectType . " " . $grade . " " . $subjectAvailableTime;
            $i++;
        }

        foreach ($this->days as $day) {
            $days    = $day->name;
            echo $days;
            $i++;
        }

        foreach ($this->rooms as $rooms) {
            $roomGrade    = $rooms->grade;
            $roomCode   = $rooms->code;
            echo $roomGrade . " " . $roomCode;
            $i++;
        }

        foreach ($this->times as $times) {
            $endTime    = $times->start_time;
            $startTime    = $times->end_time;
            echo $startTime . " " . $endTime;
            $i++;
        }
    }

    public function initiate()
    {
        $countTeacherSubject = count($this->teachersubjects);
        $countTime = count($this->time);
        $countDay = count($this->day);
        $countRoom = count($this->rooms);

        for ($i = 0; $i < $this->populasi; $i++) {

            for ($j = 0; $j < $countTeacherSubject; $j++) {

                $sks = $this->sks[$j];

                $this->individu[$i][$j][0] = $j;

                // 2 jam mapel
                if ($countSubjectAvailableTime % 2 == 0) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($countTime - 1) - 1);
                }

                // 4 jam mapel
                if ($countSubjectAvailableTime % 2 == 2) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($countTime - 1) - 3);
                }

                $this->individu[$i][$j][2] = mt_rand(0, $countTime - 1); // Penentuan hari secara acak

                // if ($this->jenis_mk[$j] === $this->TEORI) {
                //     $this->individu[$i][$j][3] = intval($this->ruangReguler[mt_rand(0, $countRoom - 1)]);
                // } else {
                //     $this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);
                // }
            }
            // dd($individu[$i]);
        }
    }
    // public function generateSchedule()
    // {
    //     foreach $teachersubject in $this->$teachersubject{
    //         $fitnest = $this->checkFitness($da)
    //             }

    //     return $fixschdule;
    // }

    // function checkFitness($darta) {

    //     return int(0)
    // }
}
