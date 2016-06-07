<?php
  // Llamada al WebService
  //$client = new SoapClient("http://www.webservicex.net/country.asmx?WSDL");
  $client = new SoapClient("https://www.mysuitetest.com/mx.com.fact.wsfront/FactWSFront.asmx?wsdl");

  /*$result = $client->GetCountries();
  $xml = $result->GetCountriesResult;
  $output="";

  $xml = simplexml_load_string($xml);
  foreach($xml->Table as $table) 
  {
    $output .= "<p>$table->Name</p>";
  }
  print_r($output);*/
?>