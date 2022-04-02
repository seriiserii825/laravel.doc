<?php 
public function importCsv()
{
  $filepath = public_path("/portfolio.csv");         //Reading file
  $file = fopen($filepath, "r");

  $importData_arr = [];
  $i = 0;

  while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
      $num = count($filedata);

      // Skip first row (Remove below comment if you want to skip the first row)
      if ($i == 0) {
          $i++;
          continue;
      }
      for ($c = 0; $c < $num; $c++) {
          $importData_arr[$i][] = $filedata [$c];
      }
      $i++;
  }
  fclose($file);

  //1 - title, 2-type, 3-domain
  // Insert to MySQL database
  foreach ($importData_arr as $importData) {
      $insertData = array(
          "title" => $importData[1],
          "domain" => $importData[3],
          "type_id" => 1,
          "image" => "some",
          "date" => "2022-04-02 08:01:32",
          "created_at" => "2022-04-02 08:01:32",
      );
//            Portfolio::firstOrCreate($insertData);
//            Page::insertData($insertData);
  }
  return response()->json([
      'data' => $importData_arr,
      'insert_data' => $insertData
  ]);
}
?>
<script>
 axios
     .get("/api/csv")
     .then((res) => {
         const result = res.data.insert_data;
         console.log(result, 'result')
          result.forEach(item => {
              console.log(JSON.stringify(item, null, 4));
          });
     })
     .catch((error) => {
         console.log(error, "error");
     });
</script>
