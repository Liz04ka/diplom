<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require("db.php");

        $name = $_POST['name'];
        $np = $_POST['np'];
        $program = $_POST['programm'];
        $clientName = $_POST['clientname'];
        $passport = $_POST['passport'];
        $issued = $_POST['issued'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $id = $_POST['id'];
        $status = $_POST['status'];

        // изменение заявки
        if (isset($_POST['change'])) {
            print_r($_POST);

            $db->query("UPDATE requests SET name='$name', program='$np', client='$clientName', passport='$passport', issued='$issued', phone='$phone', email='$email' WHERE id=$id");

            header('Location: ' . $_SERVER['HTTP_REFERER']);       
        }

        // создание договора
        if (isset($_POST['create'])) {
            // $id = $_POST['id'];

            $date = new DateTime(); 
            $date = $date -> format('Y-m-d');//текущая дата
        
            $db->query("UPDATE requests SET status='accepted' WHERE id=$id");
            $db->query("INSERT INTO contracts (id_requests) VALUES ('$id')");

            $test = $db->query("SELECT * FROM `contracts` WHERE id_requests=$id")->fetchAll(PDO::FETCH_ASSOC);
            $test = $test[0];
        
            $number = $test['number'];
            
            // $db->query("INSERT INTO payments (idcontr, date, pay) VALUES ('$number', '$date', 'Нет')");

            print_r($_POST);

        
            require_once('tspdf/tcpdf.php');
            
            // Создание кастомного header и footer 
            class MYPDF extends TCPDF {
            
                // header
                public function Header() {
                    
                    //Заголовок
                    $this->SetFont('freeserif', 'B', 11);
                    $this->Cell(0, 15, 'ДОГОВОР №76224025', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            
                    //Разрыв строк 
                    $this->Ln(5); 
            
                    //Подзаголовк
                    $this->Cell(0, 15, 'об образовании', 0, 0, 'C', 0, '', 0, false, 'M', 'M'); 
                    $this->Ln(5); 
                    $this->Cell(0, 15, '(на обучение по основной образовательной программе высшего образования)', 0, 0, 'C', 0, '', 0, false, 'M', 'M');
            
                    //Разрыв строк 
                    $this->Ln(8); 
            
                    //Нумерация
                    $this->SetFont('freeserif', '', 10);
                    $this->SetX(47);
                    $this->Cell(0, 15, 'Страница '.$this->getAliasNumPage().' из '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'M', 'M');
            
                }
            
                // Page footer
                public function Footer() {
                    $this->SetFont('freeserif', '', 10);
                    $this->SetY(-25);
                    $htmlcontent = '
                                    <div>Заказчик: <hr style="display:inline-block; width:200px; vertical-align:middle;"></div> 
                                    <div>Обучающийся: <hr style="display:inline-block; width:200px; vertical-align:right;"></div>
                                    ';
                    $this->writeHTML($htmlcontent, true, false, true, false, '');
                }
            }
            
            // create new PDF document
            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // set document information
            $pdf->SetTitle('Договор');
            
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            
            // set margins
            $pdf->SetMargins(25, 35, 10);
            $pdf->SetHeaderMargin(10);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            // ---------------------------------------------------------
            
            // set font
            $pdf->SetFont('freeserif', '', 11);
            
            // add a page
            $pdf->AddPage();
            
            //про даты
            $pdf->Cell(0, 15, 'Дата заключения договора: ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(5); 
            $pdf->Cell(0, 15, '28 мая 2024 г.', 0, false, 'R', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(5); 
            
            // Первый абзац
            $txt = <<<EOD
            <span style="font-weight:bold;">Федеральное государственное автономное образовательное учреждение высшего образования «Национальный исследовательский университет ИТМО»</span> (сокращенное наименование: Университет ИТМО), осуществляющее образовательную деятельность на основании лицензии от 09 сентября 2020 года № Л035-00115-78/00096947, выданной Федеральной службой по надзору в сфере образования и науки Российской Федерации, (далее также – <span style="font-weight:bold;">«Исполнитель»</span> или <span style="font-weight:bold;">«Университет»</span>), в лице специалиста по связям с общественностью Васильевой Ольги Владимировны, действующего на основании доверенности от 07.07.2023 № 48-07-23242, с одной стороны,
            EOD;
            $pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);
            
            //часть про фио
            $pdf->Ln(5); 
            $pdf->SetX(35);
            $pdf->Cell(0, 15, $clientName.' (далее – «Заказчик»), в лице -', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(4); 
            $pdf->SetFont('freeserif', '', 8);
            $pdf->Cell(0, 15, '(должность, Ф.И.О. лица, действующего от имени юридического лица)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(5); 
            $pdf->SetFont('freeserif', '', 11);
            $pdf->Cell(0, 15, 'действующего на основании, с другой стороны, и', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(7); 
            $pdf->SetX(35);
            $pdf->Cell(0, 15, $name, 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(4); 
            $pdf->SetFont('freeserif', '', 8);
            $pdf->Cell(0, 15, '(Ф.И.О. потребителя платной образовательной услуги; при совпадении Заказчика и Обучающегося в одном лице записать «он же»)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(5); 
            $pdf->SetFont('freeserif', '', 11);
            $pdf->Cell(0, 15, '(далее – «Обучающийся»), с третьей стороны,', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(8); 
            $pdf->SetX(35);
            $pdf->Cell(0, 15, 'далее совместно именуемые «Стороны», заключили настоящий Договор о нижеследующем:', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->Ln(10);
            $pdf->SetFont('freeserif', 'B', 11);
            $pdf->Cell(0, 15, '1. ПРЕДМЕТ ДОГОВОРА', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            
            $pdf->SetFont('freeserif', '', 11);
            $pdf->Ln(5); 
            
            $htmlcontent = '<p style="text-indent: 20px;">1.1. Исполнитель обязуется предоставить образовательную услугу, а Заказчик обязуется оплатить обучение по образовательной программе (части образовательной программы) бакалавриата по
            направлению подготовки 09.03.04 «Программная инженерия» , образовательная программа
            очной формы обучения «Системное и прикладное программное обеспечение» (далее также –
            «Программа») в пределах образовательного стандарта Университета в соответствии с учебными
            планами, в том числе индивидуальными.</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">1.2. Срок освоения Программы (продолжительность обучения) на момент подписания Договора
            составляет 4 года. Срок обучения по индивидуальному учебному плану, в том числе по ускоренному
            обучению, составляет 4 года. Под периодом предоставления образовательной услуги (периодом обучения) понимается
            промежуток времени с даты зачисления до даты окончания обучения или отчисления Обучающегося из
            Университета, которые установлены соответствующими приказами Исполнителя.</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">1.3. После освоения Обучающимся Программы и успешного прохождения государственной
            итоговой аттестации ему выдается документ об образовании и о квалификации: диплом бакалавра.</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '
            <div><hr style="display:inline-block; width:200px; vertical-align:middle;"></div>
            ';
            
            $pdf->Ln(8); 
            
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            $pdf->SetFont('freeserif', '', 8);
            $htmlcontent = '<p>
            10 Указывается число лет и месяцев.
            <br>
            9 Указывается число лет и месяцев.
            <br>
            8 Указываются следующие параметры услуги: «образовательной программе» или «части образовательной программы»; бакалавриата,
            специалитета, магистратуры или аспирантуры; код, наименование специальности или направления подготовки; наименование образовательной
            программы (части образовательной программы); форма обучения.
            <br>
            7 Указываются фамилия, имя, отчество (последнее – при наличии) потребителя платной образовательной услуги. При совпадении Заказчика и
            Обучающегося в одном лице в графе указывается «он же».
            <br>
            6 Указываются наименование и иные реквизиты документа, подтверждающего полномочия представителя Заказчика.
            <br>
            5 Указываются фамилия, имя, отчество (последнее – при наличии) и должность представителя Заказчика. Если Заказчиком выступает
            физическое лицо, действующее от своего имени (в том числе в случае совпадения Заказчика и Обучающегося в одном лице), графа не
            заполняется (в графе ставится прочерк, либо она удаляется).
            <br>
            4 Указывается фамилия, имя, отчество (последнее – при наличии) физического лица (если Заказчиком выступает гражданин) или полное
            наименование юридического лица (если Заказчиком выступает организация).
            <br>
            3 Указывается номер доверенности (при отсутствии номера указывается «б/н»).
            <br>
            2 Указывается дата выдачи доверенности.
            <br>
            1 Указываются фамилия, имя, отчество (последнее – при наличии) и должность представителя Университета ИТМО.
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            // add a page
            $pdf->AddPage();
            
            $pdf->SetFont('freeserif', 'B', 11);
            $pdf->Cell(0, 15, '1. 2. ВЗАИМОДЕЙСТВИЕ СТОРОН', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            
            $pdf->Ln(5); 
            
            $pdf->SetFont('freeserif', '', 11);
            $htmlcontent = '<p style="text-indent: 20px;">2.1. Исполнитель вправе:</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.1.1. самостоятельно осуществлять образовательный процесс, устанавливать системы оценок,
            формы, порядок и периодичность проведения промежуточной аттестации Обучающегося;</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.1.2. применять к Обучающемуся меры поощрения и меры дисциплинарного взыскания в
            соответствии с законодательством Российской Федерации, учредительными документами Исполнителя,
            настоящим Договором и локальными нормативными актами Исполнителя.</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.2. Заказчик вправе получать информацию от Исполнителя по вопросам организации и
            обеспечения надлежащего оказания услуги, предусмотренной разделом 1 настоящего Договора</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.3. Обучающемуся предоставляются академические права в соответствии с частью 1 статьи 34
            Федерального закона от 29 декабря 2012 г. N 273-ФЗ «Об образовании в Российской Федерации».
            Обучающийся также вправе:</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.3.1. получать информацию от Исполнителя по вопросам организации и обеспечения
            надлежащего оказания услуги, предусмотренных разделом 1 настоящего Договора;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.3.2. пользоваться имуществом Исполнителя, необходимым для освоения образовательной
            программы;</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.3.3. принимать участие в социально-культурных, оздоровительных и иных мероприятиях,
            организованных Исполнителем;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.3.4. получать полную и достоверную информацию об оценке своих знаний, умений, навыков и
            компетенций, а также о критериях этой оценки.</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.4. Исполнитель обязан:</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.4.1. зачислить Обучающегося, выполнившего установленные законодательством Российской
            Федерации, учредительными документами, локальными нормативными актами Исполнителя условия
            приема, в качестве студента;</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.4.2. довести до Заказчика информацию, содержащую сведения о предоставлении платных
            образовательных услуг в порядке и объеме, которые предусмотрены Законом Российской Федерации от
            7 февраля 1992 г. № 2300-1 «О защите прав потребителей» и Федеральным законом от 29 декабря 2012
            г. № 273-ФЗ «Об образовании в Российской Федерации»;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.4.3. организовать и обеспечить надлежащее оказание образовательной услуги, предусмотренной
            разделом 1 настоящего Договора. Образовательная услуга оказывается в соответствии с федеральным
            государственным образовательным стандартом или образовательным стандартом, учебным планом, в
            том числе индивидуальным, и расписанием занятий Исполнителя;</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.4.4. обеспечить Обучающемуся предусмотренные выбранной образовательной программой
            условия ее освоения;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.3.4. получать полную и достоверную информацию об оценке своих знаний, умений, навыков и
            компетенций, а также о критериях этой оценки.</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.4.5. принимать от Обучающегося и (или) Заказчика плату за образовательную
            услугу;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.4.6. обеспечить Обучающемуся уважение человеческого достоинства, защиту от всех форм
            физического и психического насилия, оскорбления личности, охрану жизни и здоровья;</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.5. Заказчик обязан своевременно вносить плату за образовательную услугу, указанную в разделе
            1 настоящего Договора, в размере и порядке, определенными настоящим Договором, а также
            предоставлять платежные документы, подтверждающие внесение указанной платы.;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.6. Заказчик обязан обеспечить посещение Обучающимся занятий согласно учебному
            расписанию, осуществлять контроль выполнения Обучающимся учебного плана, требований устава,
            правил внутреннего распорядка, правил проживания в общежитии и иных локальных нормативных
            актов Университета.
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7. Обучающийся обязан:';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7.1. добросовестно осваивать образовательную программу, выполнять индивидуальный
            учебный план, в том числе посещать предусмотренные учебным планом или индивидуальным учебным планом учебные занятия, а в случае пропуска занятий - извещать Исполнителя о его причинах,
            осуществлять самостоятельную подготовку к занятиям, выполнять задания, данные педагогическими
            работниками в рамках образовательной программы;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7.2. выполнять требования устава, правил внутреннего распорядка, правил проживания в
            общежитиях и иных локальных нормативных актов Исполнителя;</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7.3. заботиться о сохранении и об укреплении своего здоровья, стремиться к нравственному,
            духовному и физическому развитию и самосовершенствованию; </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7.4. уважать честь и достоинство других обучающихся и работников Университета, не создавать
            препятствий для получения образования другими обучающимися;</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7.5. бережно относиться к имуществу Университета.
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.8. Контроль выполнения обязательств по пункту 2.7.1 настоящего Договора может вестись
            Исполнителем на основании данных зачетных, экзаменационных ведомостей, журналов учета
            посещаемости и других учетных документов, принятых у Исполнителя.</p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $pdf->Ln(10); 
            $pdf->SetFont('freeserif', 'B', 11);
            $pdf->Cell(0, 15, '3. СТОИМОСТЬ УСЛУГИ, СРОКИ И ПОРЯДОК ОПЛАТЫ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            
            $pdf->Ln(5); 
            
            $pdf->SetFont('freeserif', '', 11);
            
            $htmlcontent = '<p style="text-indent: 20px;">. Полная стоимость платной образовательной услуги за весь период обучения Обучающегося
            составляет: рублей 00 копеек 13 1396000,00 (Один миллион триста девяносто шесть тысяч);
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">В расчете на один учебный год стоимость платной образовательной услуги по настоящему
            Договору (далее – «Годовая цена услуги») составляет: 349000 (Триста сорок девять тысяч) рублей 00
            копеек;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7. Обучающийся обязан:';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            $htmlcontent = '<p style="text-indent: 20px;">2.7.1. добросовестно осваивать образовательную программу, выполнять индивидуальный
            учебный план, в том числе посещать предусмотренные учебным планом или индивидуальным учебным планом учебные занятия, а в случае пропуска занятий - извещать Исполнителя о его причинах,
            осуществлять самостоятельную подготовку к занятиям, выполнять задания, данные педагогическими
            работниками в рамках образовательной программы;
            </p>';
            $pdf->writeHTML($htmlcontent, true, false, true, false, '');
            
            // ---------------------------------------------------------
            
            $pdf->Output('Договор_№76224022.pdf', 'I');
            
            // возвращаем на ту же страницу
            header('Location: ' . $_SERVER['HTTP_REFERER']);        
        } 
        
        // удаление заявки
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $course = $db->query("SELECT id_course FROM `requests` WHERE id=$id")->fetchColumn();
            
            $number = $db->query("SELECT number FROM contracts WHERE id_requests=$id")->fetchColumn();

            $db->query("DELETE FROM payments WHERE idcontr=$number");
            $db->query("DELETE FROM contracts WHERE id_requests=$id");
            $db->query("DELETE FROM requests WHERE id=$id");

            header('Location:table.php?id='.$course);    
            
        }
    }
?>
