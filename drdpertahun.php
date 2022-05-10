<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRD Per Tahun</title>
    <style>
        table tr th {
            border: 1px solid black;
        }
        table tr td {
            border: 1px solid black;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Data Awal</th>
                <th colspan="2">Sebelum Migrasi</th>
                <th colspan="2">Setelah Migrasi</th>
                <th colspan="2">Selisih</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tahun</td>
                <td>Lembar</td>
                <td>Rekair</td>
                <td>Lembar</td>
                <td>Rekair</td>
                <td>Lembar</td>
                <td>Rekair</td>
            </tr>
            <?php 
                require_once('connection.php');
                $sql = "SELECT LEFT(periode,4) AS tahun, COUNT(*) AS lembar, SUM(dnmet+adm+r1+r2+r3+r4) as rekair FROM ppubilling.rekair WHERE statrek = 'A' GROUP BY LEFT(periode,4)";
                $result = $conn->query($sql);
                $sql2 = "SELECT LEFT(periode, 4) AS tahun, COUNT(*) AS lembar, SUM(rekair) AS rekair FROM ppu_loket_tes.piutang GROUP BY LEFT(periode, 4)";
                $result2 = $conn->query($sql2);
                $sql3 = "SELECT LEFT(periode, 4) AS tahun, COUNT(*) AS lembar, SUM(rekair) AS rekair FROM ppu_loket_tes.bayar GROUP BY LEFT(periode, 4)";
                $result3 = $conn->query($sql3);
                if ($result->num_rows > 0) {
                    $row2 = $result2->fetch_all(MYSQLI_ASSOC);
                    $row3 = $result3->fetch_all(MYSQLI_ASSOC);
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['tahun']."</td>
                                <td style='text-align:right;'>".$row['lembar']."</td>
                                <td style='text-align:right;'>Rp".number_format($row['rekair'],0,',','.')."</td>";
                        if ($row['tahun'] == $row2[$i]['tahun']) {
                            $lembar = $row2[$i]['lembar']+$row3[$i]['lembar'];
                            $rekair = $row2[$i]['rekair']+$row3[$i]['rekair'];
                            echo "<td style='text-align:right;'>".$lembar."</td>
                                    <td style='text-align:right;'>Rp".number_format($rekair,0,',','.')."</td>";
                            echo "<td style='text-align:right;'>".($row['lembar']-$lembar)."</td>
                                    <td style='text-align:right;'>Rp".number_format($row['rekair']-$rekair,0,',','.')."</td>";
                            $i++;
                        } else {
                            echo "<td></td><td></td><td></td><td></td>";
                        }
                        echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</body>
</html>