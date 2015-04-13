<?php

App::uses('HttpSocket', 'Network/Http');

class MaShell extends AppShell {

    public $uses = array();

    public function main() {
        //$this->searchDOC();
        $this->extractDOC();
    }

    public function extractDOC() {
        $tmpPath = TMP . 'ma/p';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/ma/doc';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $targetFh = array();
        foreach (glob(TMP . 'ma/doc/page_*') AS $pageFile) {
            if (filesize($pageFile) < 1000) {
                unlink($pageFile);
                continue;
            }
            $page = file_get_contents($pageFile);
            $page = substr($page, strpos($page, '<table cellspacing="1" cellpadding="3" bordercolor="White" border="0" id="ctl00_ContentPlaceHolder1_gviewMain"'));
            $lines = explode('</tr>', $page);
            foreach ($lines AS $line) {
                $cols = explode('</td>', $line);
                if (isset($cols[1]) && false !== strpos($cols[1], 'DOC_SEQ=')) {
                    $cols[0] = trim(strip_tags($cols[0]));
                    $cols[2] = trim(strip_tags($cols[2]));
                    $cols[1] = explode('DOC_SEQ=', $cols[1])[1];
                    $cols[1] = substr($cols[1], 0, strpos($cols[1], '"'));
                    $prefix = substr($cols[1], 0, 4);
                    if (!file_exists("{$tmpPath}/{$prefix}")) {
                        mkdir("{$tmpPath}/{$prefix}", 0777, true);
                    }
                    if (!file_exists("{$tmpPath}/{$prefix}/{$cols[1]}")) {
                        //file_put_contents("{$tmpPath}/{$prefix}/{$cols[1]}", file_get_contents('https://ma.mohw.gov.tw/masearch/SearchDOC-101-2.aspx?DOC_SEQ=' . $cols[1]));
                        //$this->out("got {$cols[1]}");
                        continue;
                    }
                    if (filesize("{$tmpPath}/{$prefix}/{$cols[1]}") < 1000) {
                        unlink("{$tmpPath}/{$prefix}/{$cols[1]}");
                        continue;
                    }
                    $doc = file_get_contents("{$tmpPath}/{$prefix}/{$cols[1]}");
                    $doc = substr($doc, strpos($doc, '<div id="ctl00_ContentPlaceHolder1_Panel2">'));
                    $docLines = explode('</tr>', $doc);
                    $lineCount = 0;
                    $docData = array();
                    foreach ($docLines AS $docLine) {
                        ++$lineCount;
                        $docCols = explode('</td>', $docLine);
                        foreach ($docCols AS $docK => $docCol) {
                            $docCols[$docK] = trim(strip_tags($docCol));
                        }
                        switch ($lineCount) {
                            case 1:
                                if (!isset($docCols[3])) {
                                    print_r($docLines);
                                    exit();
                                }
                                $docData[0] = $docCols[1];
                                $docData[1] = $docCols[3];
                                break;
                            case 2:
                                $docData[2] = $docCols[1];
                                $docData[3] = $docCols[3];
                                break;
                            case 3:
                                $docData[4] = $docCols[1];
                                $docData[5] = $docCols[3];
                                break;
                            case 4:
                                $docData[6] = $docCols[1];
                                break;
                        }
                    }
                    if (!isset($targetFh[$docData[6]])) {
                        $targetFh[$docData[6]] = fopen("{$targetPath}/{$docData[6]}.csv", 'w');
                        fputcsv($targetFh[$docData[6]], array(
                            '姓名',
                            '性別',
                            '證書類別',
                            '專科資格',
                            '執登類別',
                            '執業登記科別',
                            '執業縣市',
                        ));
                    }
                    fputcsv($targetFh[$docData[6]], $docData);
                }
            }
        }
    }

    public function searchDOC() {
        $tmpPath = TMP . 'ma/doc';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $query = array(
            '__eo_obj_states' => '',
            '__eo_sc' => 'WPYNQQ6Kyp9BqnPcXW89F6SoO7krVFyWDlUByBHZPUk17i4dlQeM1ARHp5kvcEnBYCzRLUsfMqUOmadCsavm7w/xpDa9epXmDaxAtLB3+d4n9Th57QE0Nh5YgnlxZ3d9V6MLJjxSDKgvPo41ahV0Mg+7Bz5AVIwRcZDaf0T0Zqvohh1f2WmD6YHvy7p4iSHLE6216ejvd1+myNlVSumk8L1AvlO/13uTa6lk0JoLodMex6idvezcauMYsZdMLq+tZtFneoG2bVwKeCwkx6jOBY9HrD4L8gvUkbjEWyMD59GDftegjzORC5oZctQtatdvvSw5tAABpNVsrqP+IWKbliAfVpJ+VqjWVn+ycxvc6ZyFI9OVswp3s9L7a9y4Y/XDyfDZhOsofMyXTGF9khfozWLlIuXoZ4B5uOC81kHx45xD5Lk2mTGIzW6C657ikIvn0+ooGU4VtTlX5Bo1sPXPDPsM3P8FpnphJrnG8zjlrkNonK7aGojmBVgiymSLefG0714z3EoiHM2Gj5nX4i1lEBeCZgl/2ROEkGTAXt8KrKM=',
            '__EVENTTARGET' => '',
            '__EVENTARGUMENT' => '',
            '__VIEWSTATE' => 'zUhlBN+cxmManH4bUpDjJzWddujVUN7tc/dl5pzEfXrZotXIEQ1rfJkumm/V5G3kmXyNvk8Ui7OMTC6+h+ahckktkdnQUq1+LLf+AtrgxPrMfHq/XxyRka2WLMZf7QIZF+6U5/wrSnCyZQK2oLUrkCPV2kBib29liLtagLtPE0QS3Qfbe9tTkq9YR0B23UMkyMurN5XdqC4FwA1/fd1U6J1Zug7TObisHmkSRbp+6M5F+cqpqLub9yI/8Z377sWBl/NFyCTgFlT/zHAnyHjI8w0G8SPfEBw+nq2FI9bc4ycwBiMFPHPPEgYjraqm//avVDpx21y/J+IYFZtFVOHIWjbJjybUv85lNOsioBY+sZmw6pjMN3xOccW9/QFnGefbUOFvwww+ea4V4LjEaQsF624T8MPS5dDbFOv7azBdZShg9hEi94valhLiHo5ESpyYx+vjzzh9pHIcXc72Jc7Iq78ivWPoMYQY/3l6cIGLa3y8FhmwyZx/YmQcQgA+76P2tRqJlnaRdsCItMuR/NihhfdJPdZ/0/sRH4dJ4yYuaKZlD7Py8FrevaCJLwvPxzU9QizzotLIYfn3bFy1iaCkeNdcNu4J2PV4pgAWrV040Bg42c/b6zzI8e6fQGbC7pjVPV7N6X8ynao9ZWfSrHGgqaSQPZ6tZX6HJRc4CmPW7B6sVGkdstaTLAQYrTTWevrM4rO0s7WNf+8oKrAHFAZ3mkLvahtRjvDhqI1+izQwP6vJdwQgUS6oemUKiC5RVl8cw0VgSfofFeaq+EL+5L7IjYIzbMPV5b1eyJ2a79I/jVjtyXzjkML/YSWwmP0wbJxXmJ9dP6/+q0H78Xr7PjkR25tArr5QvKnKDVXTa2VoO1MoHvh0XZwmm8hp92F7wAAJK3b1lx9HmWCRycD+Y2w/tymrN/zR1PlsdbSH7HrzuWXz6ZtcNQa6rigMAS7WeDzR2/tte8hzwOEVmfrql2h1UNeuiEZXm9ypT1kVWq2Suv2iFbf4/27PsPoPXsboFf1qhSB6HDWWo5rz3OztP9OhulNPbpzSCcl0wJ/5HbQ+wsrxLZ1wt9t1QMWmDD4515gh/Ts/JbqOLeN4pbRyh8fAXJ/HdYozuKbSk5g9uRN0/fr3hAzvJysyvThautMPXFPdYFq16tfS6DdS3OihL9GvG/erNkJZ4h1wX6gj0WTOijsC5PlUBBwTfT6OZknkDE788wTL9F4Vc1ZSbNvJmlHmgBdnN3kk6mdIP+qVG0HyYxYDCjLMj6tZrOdaVtGkxoPH2Fes8IIOYqa8WHQvyWY+L09XBU8gk7al+l/GZM1vBCQqIbJdCOZ/6tBdDO/hykEJnme5cUCNNleYtHUPME3qWBnEHoqJ7/QO2QwRxdh4Bapf78Js35FuufUxezwYXBB77dcHMBHFABJ8k0HqCgtGxag8NOXcDGjEv5+C4RRYQj2dFax6L9McEHLcJXAm1tBRXvUDcfQolGxP+Tgd8FDOv1W8rKSiHEXYlt2X3qC0S4/SU1AgUieqfXPwlv/+Bs6gfg/hp8Tc8rPYWEAYxU2EKMt0V70wWQlAK42xTAr+/GcDhSBLBUvotW3Yn+Dm5nKzmoNH/Mrp+bHWJNremDwBi2bnuNK4VRObdhx4eyZaL2KINgkhrTt4PtazHQAB5a7lLs+Www0DVlSY3kMiy0hKB/CYiud+VZ4BBmlfFFfOPsbwu19lNONdK6javQfHw2O1vASJTZf8UmF3nAoujhPE3esDnTBQ7g+w8d5afcBJk8YajwXyYxR8XwOSXLp8FRCKgqSNmKeAQh7ED5mUbVqCpzdwmreXMjpRXtc/LtCREJEiBWMz2GwTvsrgkDXadsre8K5W/tY/HKNxIHjoeKrz1vSwrC+Ub3IuNTFrny4Rr0Pz8aUehdnxgBw2XEnxVYguzPruKKrVHNuhZFwv+b3TCWWqSrWkZZoESnXoJ6XGkh7COdz7HuSgSUjdMUJsZYP1dMSUyn1im/yu/wOMZpjE5QoXUzEbkcWF1mPIDJQssH/3RMH0HQ9SWWIAqEGi5hSx6GqiNUO4CBMbTffPpZj8M1/xPh4vmJpjUTJFwUMa0/eIzO85luLSLXTbw3EI/gnGalOGPm9TF788LafSNqg/npPm011WO3PeGRk9yjRkzEZRA6U+UlT9NdkcPjDY4S7zpHB+GFevj583DP91EndWt+9appaSe7GYnlUzhH4TVreGP6Dzby8ODCumTIaJG3XYQBPpeT6WShZfjA8HOYvth7nD2X6mnFI+7wsTwQoSChhKKzhyDt44wSwtGbj3j+aLtIVqJwkIMeDETq4NXJQjNgFaTpmGlB8gPP9hYPRF3vKEeybCyTJa69DfyTEcMa1kAFh4jK3beKsMS7VmK+pxphZDQUjE0neWbLiRJHAWTJQcAX8NL1rVHIgRxQ1jBUpfS5NDl44mheld0XaFCvs3Ptn5F/kKqdIx3viKjNgWAiN9rVmCsj2EW4Ar4cIJKWJJi57kflEZbRen/EAizXcsCrQ/tUYzyCYcT7e9/zcfWqfZWvg8YZsPtWD7EoQ+o9JhNWXxx83tdKEReGnhITmk30z0sRnQWGQ7cflUyvd+a3dNjrndZLoaoN0FacWiUV39BOGwaMJ9u6YEk6bNi0191JE7j1f70oaH/XAB6P0whvdnFvbQXqShFcoSu9L/WxA4mMElOYLYkLvz7GsMr9pWV1IbR2ZUIqnt3Gq9Jkbtw5INANOLgWQo0wsk4QQOwSTPpfC63orZekpPISUILWvuNSrI2p+eCt8c+dBaqk3HU4MzykcCSHEEdDA/YChX9D4XXqrPbKPPPrbsW7AmEjBwVzdmjvRixKyBTzodEp4IeelVnon+8JUbH5p4DAv+nifxD1kVKXm9a3gkaB0O9bBDF/kG/xTi77UEtgPicRmmQTU24qgPTacXMayQ9VrzGcps8bBQ1o2zY67B8VuVvvmAR2TSVRlCxWwgTWL3I59QePj2/i45391tmhd79PPgezGdGcZFe0AlFSQZv5JYSOV+3tPWwIq+iZ7LPt4yMAugjK070DKF/vSy7fTgR6Ak6ztDjv5eiupFCqj7P3quAl5gRhNFTFUj1w0G/9NdOtrwmhyLYsFmpnae6Hk/LyiiBhudYvZwHMgeUZLfqJDwKIXJPbtYm252287zxvHt06adm3zB6/vds41ly2Enl3btE5OWWMu77fnUohn3oc4jW2EtGOJbyvOzHFgggZPSzU0nwTm0noVQc377cP/BE9wnOSmXUGJrZXEhnuEbsCmb3xJjshGBX0QzrlssGfZS1FpcZAuHIiybcrfcp7py27rMjzGNmA+EAoM/WQbFyUDXYR1XIEXLN7mrN4ROdkUvVkwWBOLwerSujvKau4WJHSn1YsYPRIAvNe0mIMYfxymjqyKknjFljIBjZGUYKIrdv602pSBG2uLxhLx0xK5KbXUzV2WrevdEyEZrzmKfUXOk197y3390+MFFDDMGanMPfQf/0soZO1NhE7dv7ffK3AAYfjhRYcH+ZIcTgbLGcOHZctmsBzGtqWXq2gQ6I1Q+pyWiBtk3qrPVfLnspEunuzxzX0mSpJkrF0x30h9cxrPzXGsg2qMos3Pa8pM+8X5weYIPZ8bNvJLGj7f5NuHfQY93V5LgFEUjhbIqd4wPacsnVX0NhU3jxZaqtlbb/fW7ZM96xF+YCe8Jj57aUHw/WcgsW4V9QG2xHITq7U2QeZicz0otvdOrZuPfBzVeyMPuZr/CozMH9AOe/M1mZxkuPNkun06QpmNZk2hODTr61uhPiokyHmdN/mizt161z2rug2yvdypSCg7QOIhtQoARKN+qlMbY4MpTVX6CUpAhjO3xJUKXZSXKGEI6zGAb/vhGmQh45ElctY9NFzSt/gGw41Kn25uO2pVcB7IU30v20sc+P9HFlXNI7yKRWPf9QnPb56Jl2EAhxPhaT42iykSdR+jGsNUh/4+K5GgtV0xSI5qUJuFBY9934IPf5g+JjyUCipj8sLBvkpwZAYGKDbMMjLUpxRHgWgH2/Gdb3JujeIXuOv66IiE8YtbdrdyDedpz4iGz1hWdjCZ25wQblqZZErl+QwTRUx4pOvrdi0xuK8bki6vvrH85x2KClUgeCONDID6bADEuQcrnpEdyADeANFkGwYzlw5MIuL0xI6gCKYs6INJBgA9bhloN2GklKUVWDI5k2qDkK+YGljpMJjiT2qzeE4MPjdjak5GDTE7it2DYryeIuvSceOkTRHeItjAOOWcHaZlr1J3/uMdYlAKDaFBF6DfXXtQ37vExZLKJzuW3sDMfH2Xx1VcsnJ1uXlU9Nf0yId/pa1nC4AZEPG1wHAmq7DbM1Ue4LfLf3Ea9UMjgX7RlJRsOVqZCuKEpTsggG/tpGsA1omAUqjKHdjSZSUND+rBxn7U6joT1ttH0QB8Odxt60Ekd/wIU71MSzLesK8zaGTU=',
            'eo_version' => '12.0.10.2',
            'eo_style_keys' => '/wFk',
            'ctl00$ContentPlaceHolder1$txtDOC_NAME' => '%%',
            'ctl00$ContentPlaceHolder1$ddlREF_ID' => '',
            'ctl00$ContentPlaceHolder1$ddlPRT_AREA' => '',
            'ctl00$ContentPlaceHolder1$TextBox1' => '',
            'ctl00$ContentPlaceHolder1$NetPager1$txtPage' => '1',
            'ctl00$ContentPlaceHolder1$NetPager1$btGo' => 'Go',
            '__VIEWSTATEENCRYPTED' => '',
            '__EVENTVALIDATION' => 'WPYNQQ6Kyp9BqnPcXW89F6SoO7krVFyWDlUByBHZPUk17i4dlQeM1ARHp5kvcEnBYCzRLUsfMqUOmadCsavm7w/xpDa9epXmDaxAtLB3+d4n9Th57QE0Nh5YgnlxZ3d9V6MLJjxSDKgvPo41ahV0Mg+7Bz5AVIwRcZDaf0T0Zqvohh1f2WmD6YHvy7p4iSHLE6216ejvd1+myNlVSumk8L1AvlO/13uTa6lk0JoLodMex6idvezcauMYsZdMLq+tZtFneoG2bVwKeCwkx6jOBY9HrD4L8gvUkbjEWyMD59GDftegjzORC5oZctQtatdvvSw5tAABpNVsrqP+IWKbliAfVpJ+VqjWVn+ycxvc6ZyFI9OVswp3s9L7a9y4Y/XDyfDZhOsofMyXTGF9khfozWLlIuXoZ4B5uOC81kHx45xD5Lk2mTGIzW6C657ikIvn0+ooGU4VtTlX5Bo1sPXPDPsM3P8FpnphJrnG8zjlrkNonK7aGojmBVgiymSLefG0714z3EoiHM2Gj5nX4i1lEBeCZgl/2ROEkGTAXt8KrKM=',
        );
        for ($i = 1; $i <= 28187; $i ++) {
            if (file_exists("{$tmpPath}/page_{$i}") && filesize("{$tmpPath}/page_{$i}") > 1000) {
                continue;
            }
            $query['ctl00$ContentPlaceHolder1$NetPager1$txtPage'] = (string) $i;

            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Cookie: _ga=GA1.3.1542454863.1422285706; ASP.NET_SessionId=1hukgq451wk5zz55eaoeucrp; SearchDOC-101-1_SearchCondition=txtDOC_NAME=%25%25&ddlREF_ID=&ddlPRT_AREA=&txtPage=\r\n"
                    . "Referer: https://ma.mohw.gov.tw/masearch/SearchDOC-101-1.aspx",
                    'content' => http_build_query($query),
                )
            );

            $context = stream_context_create($opts);

            $result = file_get_contents('https://ma.mohw.gov.tw/masearch/SearchDOC-101-1.aspx', false, $context);

            file_put_contents("{$tmpPath}/page_{$i}", $result);

            $pos = strpos($result, 'type="hidden"');
            while (false !== $pos) {
                $posEnd = strpos($result, '/>', $pos);
                $parts = preg_split('/ +/', substr($result, $pos, $posEnd - $pos));
                $currentName = $currentValue = '';
                foreach ($parts AS $part) {
                    $pair = array();
                    $pair[0] = substr($part, 0, strpos($part, '='));
                    $pair[1] = substr($part, strpos($part, '=') + 1);
                    switch ($pair[0]) {
                        case 'name':
                            $currentName = substr($pair[1], 1, -1);
                            break;
                        case 'value':
                            $currentValue = substr($pair[1], 1, -1);
                            break;
                    }
                }
                if (!empty($currentName) && isset($query[$currentName])) {
                    $query[$currentName] = $currentValue;
                }
                $pos = strpos($result, 'type="hidden"', $posEnd);
            }

            $this->out("got page {$i}");
        }
    }

}
