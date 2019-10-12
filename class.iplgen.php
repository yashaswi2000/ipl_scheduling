<?php 

class iplgen 
{

    public $matrix;
    private $teams;
    private $teams1;
    private $teams2;
    public $matches;
    

    public function __construct($passedTeams = null) 
    {
        $this->teams = $passedTeams;
        $this->matches = array();
        $this->matrix = array(
            array(-1,0,0,0,0,0,0,0),
            array(0,-1,0,0,0,0,0,0),
            array(0,0,-1,0,0,0,0,0),
            array(0,0,0,-1,0,0,0,0),
            array(0,0,0,0,-1,0,0,0),
            array(0,0,0,0,0,-1,0,0),
            array(0,0,0,0,0,0,-1,0),
            array(0,0,0,0,0,0,0,-1)
        );
    }

    public function generate($startingDate)
    {
        $i = 0;
        $x = 0;
        $y = 0;
        $x1 = 0;
        $y1 = 0;
        $x2 = 0;
        $y2 = 0;
        $x3 = 0;
        $y3 = 0;

        while($i!=56)
        {

            $day = strtotime($startingDate);
            $weekday = date("l",$day);
            if(strcmp("Saturday",$weekday)==0)
            {

                for($j=0;$j<8;$j++)
                {
                    $temp = 0;
                    for($k=0;$k<8;$k++)
                    {
                        if(($this->matrix[$j][$k]==0) &&  ($j!=$x1-1) && ($k!=$y1-1) && ($k!=$x1-1) && ($j!=$y1-1))
                        {
                            $x = $j+1;
                            $y = $k+1;
                            $matches_tmp[] = array($x ,$y);
                            $this->matches[] = $matches_tmp;
                            $x2 = $x;
                            $y2 = $y;
                            $this->matrix[$j][$k]=1;
                            $temp =1 ;
                            break;
                        }
                    }
                    if($temp==1)
                    {
                        break;
                    }
                }
                for($j=0;$j<8;$j++)
                {
                    $temp =0;
                    for($k=0;$k<8;$k++)
                    {
                        if($this->matrix[$j][$k]==0 && $j!=$x1-1 && $k!=$y1-1 && $j!=$x2-1 && $k!=$y2-1 && ) 
                        {
                            $x = $j+1;
                            $y = $k+1;
                            $matches_tmp[] = array($x ,$y);
                            $this->matches[] = $matches_tmp;
                            $x1 = $x2;
                            $y1 = $y2;
                            $x2 = $x;
                            $y2 = $y;
                            $this->matrix[$j][$k]=1;
                            break;
                        }
                    }
                    if($temp==1)
                    {
                        break;
                    }
                }



            }
            else if(strcmp("Sunday",$weekday)==0)
            {
                for($j=0;$j<8;$j++)
                {
                    for($k=0;$k<8;$k++)
                    {
                        if($this->matrix[$j][$k]==0 && $j!=$x1-1 && $k!=$y1-1 && $j!=$x2-1 && $k!=$y2-1) 
                        {
                            $x = $j+1;
                            $y = $k+1;
                            $matches_tmp[] = array($x ,$y);
                            $this->matches[] = $matches_tmp;
                            $x3 = $x;
                            $y3 = $y;
                            $this->matrix[$j][$k]=1;
                            break;
                        }
                    }
                }
                for($j=0;$j<8;$j++)
                {
                    for($k=0;$k<8;$k++)
                    {
                        if($this->matrix[$j][$k]==0 && $j!=$x1-1 && $k!=$y1-1 && $j!=$x2-1 && $k!=$y2-1 && $j!=$x3-1 && $k!=$y3-1) 
                        {
                            $x = $j+1;
                            $y = $k+1;
                            $matches_tmp[] = array($x ,$y);
                            $this->matches[] = $matches_tmp;
                            $x1 = $x3;
                            $y1 = $y3;
                            $x2 = $x;
                            $y2 = $y;
                            $this->matrix[$j][$k]=1;
                            break;
                        }
                    }
                }
            }
            else if(strcmp("Monday",$weekday)==0)
            {
                for($j=0;$j<8;$j++)
                {
                    for($k=0;$k<8;$k++)
                    {
                        if($this->matrix[$j][$k]==0 && $j!=$x1-1 && $k!=$y1-1 && $j!=$x2-1 && $k!=$y2-1) 
                        {
                            $x = $j+1;
                            $y = $k+1;
                            $matches_tmp[] = array($x ,$y);
                            $this->matches[] = $matches_tmp;
                            $x1 = $x;
                            $y1 = $y;
                            $this->matrix[$j][$k]=1;
                            break;
                        }
                    }
                }
            }
            else{
                for($j=0;$j<8;$j++)
                {
                    for($k=0;$k<8;$k++)
                    {
                        if($this->matrix[$j][$k]==0 && $j!=$x1-1 && $k!=$y1-1)
                        {
                            $x = $j+1;
                            $y = $k+1;
                            $matches_tmp[] = array($x ,$y);
                            $this->matches[] = $matches_tmp;
                            $x1 = $x;
                            $y1 = $y;
                            $this->matrix[$j][$k]=1;
                            break;
                        }
                    }
                }
            }
            $i++;
            $startingDate = date('Y-m-d', strtotime('+1 day', strtotime($startingDate)));
        }
        
    }

    private function saveMatchday() {
        for ($i = 0; $i < count($this->teams1); $i++) {
         
                $matches_tmp[] = array($this->teams1[$i], $this->teams2[$i]);
        }
        $this->matches[] = $matches_tmp;
        return true;
    }





    public function setDates($schedule, $startingDate) {

        $date = $startingDate;
        $schedule[0]['date'] = $date;

        $weekendCount = 0;
        for ($i=1; $i < count($schedule); $i++) { 

            (!$this->isWeekend($date)) ? $date = date('Y-m-d', strtotime('+1 day', strtotime($date))) : $weekendCount++ ;

            if($weekendCount == 2) {
                $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
                $weekendCount =  0;
            }
            $schedule[$i]['date'] = $date;
        }

        return $schedule;
        
    }

    private function isWeekend($date) {
        return (date('N', strtotime($date)) >= 6);
    }

}
?>
