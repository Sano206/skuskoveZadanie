<?php
include 'config.php';

$a = $conn->prepare ("SELECT * FROM test_complete WHERE test_id = :test_id");
$a->bindParam(":test_id", $_GET['id']);
$a->execute();
$complete_test = $a->fetchAll();

$test = $conn->prepare ("SELECT * FROM test_complete WHERE test_id = :test_id and student_id = :student_id");
$test->bindParam(":test_id", $_GET['id']);

$option = $conn->prepare ("SELECT * FROM options WHERE question_id = :question_id");


$students_id = array();
//$question_id = array();

foreach ($complete_test as $row)
{
    if(!in_array($row['student_id'], $students_id))
    {
        array_push($students_id, $row['student_id']);
    }
    //array_push($question_id, $row['question_id']);
}

$i = 0;
$student = $conn->prepare ("SELECT * FROM students WHERE id = :student_id");

$b = $conn->prepare ("SELECT * FROM questions WHERE test_id = :test_id");
$b->bindParam(":test_id", $_GET['id']);


//include library
include ('library/tcpdf.php');

//make TCPDF object
$pdf = new TCPDF('P', 'mm', 'A4');

//remove default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//add page
$pdf->AddPage();

//add content
$pdf->Cell(190, 10, "Test", 1, 1, 'C');

//using html cell
$html = '';
foreach ($students_id as $row)
{
    $student->bindParam(":student_id", $students_id[$i]);
    $student->execute();
    $studentInfo = $student->fetchAll();

    //$b->bindParam(":question_id",$question_id[$i]);
    $b->execute();
    $complete_student_id = $b->fetchAll();

    $html .="
            <table>
                <tr>
                    <th><strong>Name</strong></th>
                    <th><strong>Last Name</strong></th>
                </tr>
                <tr>
                    <td>". $studentInfo[0]['name'] ."</td>
                    <td>". $studentInfo[0]['surname'] ."</td> 
                </tr>
                </table>
                 <br><br>
            ";

    $html .= "
            <table>
                <tr>
                    <th><strong>Question</strong></th>
                    <th><strong>Answer</strong></th>
                    <th><strong>Correct answer</strong></th>
                </tr>
             ";

    $test->bindParam(":student_id", $students_id[$i]);
    $test->execute();
    $student_answer = $test->fetchAll();
    $j = 0;
    foreach ($complete_student_id as $rows)
    {
        if ($rows['type'] == 'connection')
        {
            $option->bindParam(":question_id", $rows['id']);
            $option->execute();
            $complete_test = $option->fetch();

                $html .= "
               <tr>
                   <td>Q1</td>
                   <td>". $student_answer[$j]['answer']."</td> 
                   <td>".$complete_test['option1']."</td>
               </tr>
            
           <br><br>
           ";
            $j++;

            if($j >= count($student_answer))
            {
                $student_answer[$j]['answer'] = "";
            }
            $html .= "
               <tr>
                   <td>Q2</td>
                   <td>". $student_answer[$j]['answer']."</td> 
                   <td>".$complete_test['option2']."</td>
               </tr>
            
           <br><br>
           ";
            $j++;

            if($j >= count($student_answer))
            {
                $student_answer[$j]['answer'] = "";
            }
            $html .= "
               <tr>
                   <td>Q3</td>
                   <td>". $student_answer[$j]['answer']."</td> 
                   <td>".$complete_test['option3']."</td>
               </tr>
            
           <br><br>
           ";


        }else{
            $html .= "
               <tr>
                   <td>".$rows['question'] . "</td>
                   <td>". $student_answer[$j]['answer']."</td> 
                   <td>".$rows['answer']."</td>
               </tr>
            
           <br><br>
           ";
        }
        $j++;
        if($j >= count($student_answer))
        {
            $student_answer[$j]['answer'] = "";
        }
    }
    $html .= "</table><br><br>";
    //$pdf->Cell(10, 5, $row['student_id'], 1);
    //$pdf->Ln();
    $i++;
}

$pdf->WriteHTMLCell(192, 0, 9, '', $html, 0);
//output
$pdf->Output();