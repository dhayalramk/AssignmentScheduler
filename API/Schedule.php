<?php

class Schedule extends API implements IAPI
{
    private $team;
    private $startDate;
    private $allMatches = [];
    private $players;
    private $response = [];
    private $completed = [];

    private $dateHelper;



    public function execute()
    {
        $canContinue = true;

        if ($canContinue) {
            $canContinue = $this->checkInput();
        }
        
        if ($canContinue) {
            $canContinue = $this->initialize();
        }

        if ($canContinue) {
            $this->logic();
        }

        if ($canContinue) {
            $this->output();
        }
    }

    public function initialize()
    {
        $this->startDate = $_GET['startDate'];
        for ($i=0;$i<count($this->team);$i++) {
            $this->players[$this->team[$i]]  = 9;
        }
        return true;
    }

    public function checkInput()
    {
        $this->team = ['A','B','C','D', 'E', 'F'];
        return true;
    }

    public function logic()
    {
        $processDate = $this->startDate;
        $this->generateAllMatches();
        $matchCount = 0;
        $totalMatch = count($this->allMatches);
        while ($matchCount != $totalMatch) {
            $this->response[$processDate] = [];
            $todayMatchCount = $this->getHelper('DateHelper')->isWeekDay($processDate) ? 1 : 2;
            $j=0;
            while ($todayMatchCount) {
                $todayMatchCount--;
                for (;$j<$totalMatch;$j++) {
                    if (
                        !in_array($this->allMatches[$j][0].'-'. $this->allMatches[$j][1], $this->completed)
                        &&
                        $this->canMatch($this->allMatches[$j][0], $this->allMatches[$j][1])
                    ) {
                        $this->doMatch($this->allMatches[$j][0], $this->allMatches[$j][1]);
                        // unset($this->allMatches[$j]);
                        $this->response[$processDate][] = [ $this->allMatches[$j][0], $this->allMatches[$j][1] ];
                        $matchCount++;
                        break;
                    }
                }
            }
            if (empty($this->response[$processDate])) {
                $this->response[$processDate] = 'No Match Today';
            }
            
            $processDate = $this->getHelper('DateHelper')->nextDate($processDate);
            $this->playersRest();
        }
    }

    public function output()
    {
        $this->responseObj->output($this->response);
    }

    private function playersRest()
    {
        foreach ($this->players as $key => $value) {
            $this->players[$key]++;
        }
    }

    private function generateAllMatches()
    {
        $n = count($this->team);
        for ($i=0;$i<$n;$i++) {
            for ($j=0;$j<$n;$j++) {
                if ($i!=$j) {
                    $this->allMatches[] = [ $this->team[$i], $this->team[$j] ];
                }
            }
        }
    }

    private function canMatch($p1, $p2)
    {
        return $this->players[$p1] > 1 && $this->players[$p2] > 1;
    }

    private function doMatch($p1, $p2)
    {
        $this->players[$p1] = 0;
        $this->players[$p2] = 0;
        $this->completed[] = $p1.'-'.$p2;
    }
}

// echo '<pre>';
// $scheduleAPI = new Schedule(['A','B','C','D']);
