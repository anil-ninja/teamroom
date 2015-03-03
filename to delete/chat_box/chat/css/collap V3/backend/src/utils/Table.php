<?php
require_once 'utils/Base.php';
/**
 * Quick and easy table creation in our code :)
 * @author kmehra
 *
 */

class Table extends Base {
	/**
	 * An array containing the table headers. is an associative array (colindex => colname)
	 * @var array
	 */
	private $headers;
	/**
	 * An array of arrays containing the table body. Is of the form:
	 * Row1: array(colindex => data, colindex2 => data2)
	 * Row2: array(colindex => data, colindex2 => data2)
	 * @var array
	 */
	private $data;
	/**
	 * Style used for this table
	 * @var string
	 */
	private $style;
	private $js;
	/**
	 * order used to display the header fields, array(colindex5, colindex3, ...)
	 * @var array
	 */
	private $headerOrder;

	var $name;

	//accordion parameters
	var $accordion_name;
	var $overall = array();
	var $accordion_group_column;
	var $accordion_group_row;
	var $use_accordion ;

	public $extra_table_attrs;
	public $header_custom_hash;

	private $checkbox_column;
	//pagination
	var $page_id;
	var $use_pagination;
	var $table_name;
	private $jsMod;
	private $border;
	private $kpi;
	private $kpi_selection_hash;
	private $kpi_type_selection_field;
	/**
	 * Consturct a table object
	 * @param $name Table name (also used as the ID)
	 * @return Table object
	 */
	function __construct($name = "",$accordion_name = '') {
		parent::__construct();
		global $jsController;
		global $js;

		$headers = array();
		$this->style = $style;
		$this->jsMod = $js;
		$this->js = $jsController;

		$this->data = array();
		$this->use_accordion = false;
		$this->page_id = 1;
		$this->use_pagination = false;
		if($name!=""){
			$this->name = $name;
		}
		if($accordion_name == '')
			$this->accordion_name = 'accordion';
		else{
			$this->accordion_name = $accordion_name;
			$js->addAccordion($accordion_name);
		}
		if($this->name){

			$this->table_name = 'table_'.$this->name;
			$js->addHeader( $this->table_name, $this->headers );
		}else
			$this->table_name = 'box-table-a';
		$this->style = 'box-table-a';
		$this->border = 0;
	}

	function setKpiSelectionField( $type_selection_field ){

		$this->kpi_type_selection_field = $type_selection_field;
	}

	public function getData(){

		return $this->data;
	}

	public function getIData(){

		$iData = array();
		for( $i = 0 ; $i < count( $this->data ) ; $i++ ){

			$iData[$i] = array();
			foreach( $this->headerOrder as $header ){

				$iData[$i][$header] =
					( $this->data[$i][$header] ) ? ( $this->data[$i][$header] ) : ( 0 );
			}
		}

		return $iData;
	}

	/**
	 * Import an array of rows into a table with all the headers etc.
	 * @param $create_data array, the array of rows to import
	 * @param $headers, (optional) list of headers for the table
	 * @return void
	 */
	function importArray( $create_data, $headers = NULL) {

		if( !is_array( $create_data ) )
			return ;

		$this->data = array();
		$this->headers = '';
		$this->headerOrder = '';

		if (!$create_data || sizeof($create_data) == 0) return;

		foreach( $create_data as $key => $value ){

			if( !$key )
				continue;

			$first_key = $key;
			break;
		}
		if(!$first_key)
			$first_key = 0;

		if ($headers == NULL) $headers = array_keys($create_data[$first_key]);

		$this->data = $create_data;
		foreach ($headers as $h) {
			$this->addHeader($h);
		}
	}

	/**
	 * Import the entries of a table from a K-V Associative Array
	 * @param $kvpairs array of key => value pairs
	 * @param $keyHeader Header to be shown for the Key column
	 * @param $valueHeader Header to be shown for hte Value column
	 * @return void
	 */
	function importFromKeyValuePairs(array $kvpairs, $keyHeader = 'Key', $valueHeader = 'Value') {
		$this->data = array();
		$this->headers = '';
		$this->headerOrder = '';

		$this->addHeader('key', $keyHeader);
		$this->addHeader('value', $valueHeader);

		foreach ($kvpairs as $k => $v) {
			$this->addRow(array('key' => $k, 'value' => $v));
		}
	}

	/**
	 * Add a header field to the table
	 * @param $colindex index of the header column
	 * @param $colname Column header that is displayed, can be picked up by doing beautify() on the index above
	 * @return void
	 */
	function addHeader($colindex, $colname = '') {
		if ($colname == '') $colname = Util::beautify($colindex);
		$this->headers[$colindex] = $colname;
	}

	/**
	 * @deprecated
	 * @see reorderHeaders()
	 * Remove a header field from the form headers
	 * @param $colindex Column index to Remove
	 * @return void
	 */
	function removeHeader($colindex) {
		if ($this->headers && $colindex < sizeof ($this->headers))
			unset($this->headers[$colindex]);
	}

	/**
	 * Add the form data
	 * @param $data
	 * @return unknown_type
	 */
	function addData($data) {

		$data = !is_array( $data ) ? array() : $data ;
		$this->data = !is_array( $this->data ) ? array() : $this->data ;

		$this->data  = array_merge($this->data, $data);
	}

	/**
	 * Add a row into the data table. It should be an array of (colindex => data)
	 * @param $row associative array
	 * @return unknown_type
	 */
	function addRow($row) {
		array_push($this->data, $row);
	}

	/**
	 * Add Many Columns To The Table In One Call..
	 * @param array Heading Names
	 * @param function callback defination name
	 * @param array parameters
	 */
	function addManyFieldsByMap(array $headings,$callback,$params = array(),$join = array()) {
		global $logger;
		$header = array();
		$i=0;
		foreach($headings as $heading){

			$header[$i] = Util::uglify($heading);
			$this->headers[$header[$i]] = $heading;
			$i++;
		}
		foreach($this->data as &$row) {
			$ret_val = array();
			if($join)
				$ret_val = call_user_func($callback, $row, $params,$join);
			else
				$ret_val = call_user_func($callback, $row, $params);
			//$logger->info($ret_val);

			for($k=0;$k<$i;$k++){
				$row[$header[$k]] = $ret_val[$k];
			}
		}
	}
	/**
	 * Add a field to the table using the mapping function provided
	 * @param $heading Heading to use for the column
	 * @param $callback Function callback object to call. See php documentation for function callback
	 * @param $params any extra parameters to be passed to the function
	 * @param $code The header code to be used. Uglifies heading by default
	 * @return void
	 */
	function addFieldByMap($heading, $callback, $params = array(), $code = NULL) {
		global $logger;
		if ($code == NULL)
		$h = Util::uglify($heading);
		else $h = $code;

		if(count($this->data) > 0){
			$this->headers[$h] = $heading;
			$cb_str = is_array($callback)? $callback[1] : $callback;
			$logger->debug("Adding $heading [ugly- $h] by applying $cb_str to each row");
			foreach ($this->data as &$row) {
				//$logger->debug("working on row: ".print_r($row, true));
				$val = call_user_func($callback, $row, $params);
				//$logger->debug("received value: $val");
				$row[$h] = $val;
			}
		}
	}

	/**
	 * @param $callback Function to call for each row. Function should return the modified row which will replace the existing row.
	 * @param $extraheaders An array of new headers that will be added to each of the rows
	 * @param $params Any parameters to pass to the callback function
	 * @return unknown_type
	 */
	function addManyFields($callback, $extraheaders, $params = array()) {
		global $logger;

		if(count($this->data) > 0){
			$cb_str = is_array($callback)? $callback[1] : $callback;
			$logger->debug("Modifying rows by applying $cb_str to each row");
			foreach ($this->data as &$row) {
				$row = call_user_func($callback, $row, $params);
			}

			//add the new headers to the table
			foreach($extraheaders as $header){
				$this->addHeader($header);
			}
		}
	}

	/**
	 * Exclude certain rows in the table based on some condition
	 * @param $callback Function should return true for inclusion and false otherwise. Function callback object to call. See php documentation for function callback
	 * @param $params Any extra parameters to be passed to the function
	 * @return Modifies the table data directly. Returns the rows which are excluded
	 */
	function excludeRows($callback, $params = array()){

		$included_rows = array();
		$excluded_rows = array();

		foreach ($this->data as $row) {
			$val = call_user_func($callback, $row, $params);
			if($val)
				array_push($included_rows, $row);
			else
				array_push($excluded_rows, $row);
		}

		$this->data = $included_rows;

		return $excluded_rows;
	}

	function setData($data, $column = ''){
		$this->data = $data;
		$this->checkbox_column = $column;
	}

	function setStyle($style) {
		$this->style = $style;
	}
	/**
	 * Create a link as a new column
	 *
	 * @param $heading Heading to be shown for this column
	 * @param $link Link body with template eg., {0}, {1}
	 * @param $anchor_text Link Anchor text
	 * @param $params Params to be replaced with eg., array(0 => 'id', 1 => 'name'); the values should exist in the row (which is an array)
	 * @param $code the code to be used for this column (DEFAULT: uglify($heading))
	 * @return void
	 */
	function createLink($heading, $link, $anchor_text, $params, $code = NULL){
		if(function_exists('linkMaker') == false){
			function linkMaker($row, $params){
				$l = $params['link'];
				$t = $params['anchor_text'];
				foreach($params['params'] as $key => $value){
					$l = str_replace('{'.$key.'}', $row[$value], $l);
					$t = str_replace('{'.$key.'}', $row[$value], $t);
				}
				return '<a href="'.$l.'">'.$t.'</a>';
			}
		}
		$this->addFieldByMap($heading, 'linkMaker', array( 'link'=> $link, 'anchor_text' => $anchor_text, 'params' => $params), $code);
	}

	private function prePopulateProcessing() {
		if ($this->headers == false) {
			$this->headers = array("Empty");
		}
		if ($this->headerOrder == false) {
			$this->headerOrder = array_keys($this->headers);
		}
	}

	public function getTableName(){

		return $this->table_name;
	}

	public function getPassedName(){

		return $this->name;
	}

	public function addPagintion(){

		$current_page_id = $this->page_id;

		$prev_page_id = $current_page_id -1;
		$show_next_page = $current_page_id + 1;
		$name = $this->name;
		$pageURL .= $_SERVER["REQUEST_URI"];

		if($prev_page_id > 0){
			$str = "<a id = '$name' href= $pageURL&table_name=$name&page_id=$prev_page_id> prev <<< $prev_page_id </a>";
			$str .= '&nbsp;&nbsp;&nbsp;&nbsp;';
		}

		$start = (($prev_page_id -5) > 0)?($prev_page_id -5):(1);
		$end = ($start)?($current_page_id + 5):(10);

		for($i = 0 ; $i < 2 ; $i++){
			$str .= "<a id = '$name' > -- </a>";
			$str .= '&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		for($i = $start ; $i <= $end ; $i++){
			if($i == $current_page_id)
				$str .= "<a type = 'button' id = '$name' style = 'color:red' href= $pageURL&table_name=$name&page_id=$i> <b>$i</b> </a>";
			else
				$str .= "<a id = '$name' href= $pageURL&table_name=$name&page_id=$i> $i </a>";
			$str .= '&nbsp;&nbsp;||&nbsp;&nbsp;';
		}
		for($i = 0 ; $i < 2 ; $i++){
			$str .= "<a id = '$name' > -- </a>";
			$str .= '&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		$str .= "<a id = '$name' href= $pageURL&table_name=$name&page_id=$show_next_page> $show_next_page >>> next </a>";
		return $str;
	}
	/**
	 * Convert final Table data into an array so that it can be imported by other parts of the framework
	 * @return unknown_type
	 */
	public function exportToArray() {
		$this->prePopulateProcessing();
		$arr = array(); $arr[0] = array();
		foreach ($this->headerOrder as $i) {
			array_push($arr[0], $this->headers[$i]);
		}
		foreach ($this->data as $row) {
			$new_row = array();
			foreach ($this->headerOrder as $i) {
				array_push($new_row, $row[$i]);
			}
			array_push($arr, $new_row);
		}
		return $arr;
	}
	/**
	 * generate html by array 2d array
	 *
	 * @param $overall_array
	 * @return unknown_type
	 */
	function generatehtmlByArray($row,$width){

		$str = ("<table id=\"$this->style\" summary=\"table\"  $this->extra_table_attrs>
				");
		$str .= "<tr>";
//		$data = $this->data;

		foreach ($this->headerOrder as $i){
			//$value = '{'.$data[$row_id][$i].'}';
			$value = ($row[$i])?($row[$i]):('NA');
			//$str .= "<div style=\"width:".$width."%; height:20px;overflow:hidden;float:left; text-align:left;\">$value</div>";
			$str .="<td colspan = '3' width = '50'>$value</td>";
		}
		$str .= "</tr>";
		$str.="</table>";

		return $str;

	}

	function setDisplayTypeAsAccordion(){
		$this->use_accordion = true;
	}
	function setAccordionParameters($group_column,array $group_row){

		$this->accordion_group_column = $group_column;
	 	$this->accordion_group_row = $group_row;

	}

	function createAccordionTable(){

		$this->prePopulateProcessing();


		$str = ("
			<form method=post action=''>
			<table id=\"$this->style\" summary=\"table\" $this->extra_table_attrs >
			<thead>
				<tr>");
		$str .= "<td>------</td>";
//		$str .= "<div style=\"overflow:hidden;width:100%\">";
//		$width = 100/(count($this->headerOrder)+1);
//		$str .= "<div style=\"width:".$width."%; height:40px;text-align:left;float:left; text-align:right;background:#00FFFF;\"> </div>";
		foreach ($this->headerOrder as $i){

			$name = $this->headers[$i].'||';
//			$str .= "<div style=\"width:".$width."%; height:40px;float:left; background:#06799F;\"> $name</div>";

		$str.= "<td style = 'overflow:hidden'>$name</td>";
		}$str .= "</div>";
		$str .="</tr></thead></table></form>";

		$str .= "<br><br><br>";
		$str .= "<div id='$this->accordion_name'>";

		$row_id = 0;
		$width = 100/(count($this->headerOrder));
		foreach($this->accordion_group_row as $rn){
			$col = 1;

			foreach($this->data as $row){

				if($row[$this->accordion_group_column] == $rn){

					if($col == 1){
						$col++;
						$summary = $this->generatehtmlByArray($row,$width);
						$str .= "<div style = 'width:100%;overflow:hidden' ><a href='#'>$summary</a></div>";
						//$str .= "<div>";
						$str .= ("
								<form method=post action=''>
								<table id=\"$this->style\" summary=\"table\" $this->extra_table_attrs>
								<thead>
									<tr>");
						foreach ($this->headerOrder as $i){

							$name = $this->headers[$i];
							$str.= "<td scope='col'>$name</td>";
						}
						$str .="</tr></thead><tbody>";
					}
					$str .= "<tr>";
					foreach ($this->headerOrder as $i){
						$str .="<td>$row[$i]</td>";
					}
					$str .= "</tr>";
				}
			}
			$str.="</tbody></table></form>";
		}
		$str .= "</div>";
		return $str;
	}

	function setPagination(){
		$this->use_pagination = true;
	}

	function generateKpiTableHTML( $table_id = false, $family_id = false, $measure_id = false ){

		$this->loadKpi( $family_id );
		$str = $this->createKpiTable( $table_id, $family_id, $measure_id  );

		return $str;
	}
	
	function generateHTML( $report = false, $listener = false ){

		if( $listener == true ){

			$str = $this->createListenerTable();
		}else{

			if($report){
				$this->table_name = 'box-table-a';
				$this->border = 1;
			}

			if($this->use_accordion)
				$str = $this->createAccordionTable();
			else
				$str = $this->createNormalTable();

			if($this->use_pagination)
				$str .= $this->addPagintion();
		}

		return $str;
	}

	function createListenerTable(){
		$this->prePopulateProcessing();
		$str= ("
			<style type='text/css'>
				th{
					background-color: #5B3;
					color:white;
					font-style:italic;
					text-align: center;
					font-size:14px;
				 }
				.borderTable {
					border: 1px solid #660000;
				}
				#borderTable {
					padding: 2px 4px 2px 4px;
					border: 1px solid #990066;
				}
			</style>
		<div id = ''>
			<table class='borderTable'>
					<thead>
				<tr>");

				foreach ($this->headerOrder as $i):
				$name = $this->headers[$i]; $str.= "
							<th >$name</th>";
				endforeach;
				$str .="</tr></thead><tbody>
					";
				foreach ($this->data as $row): $str .="
						<tr class ='right'>";
				foreach ($this->headerOrder as $i):$str.="
							<td style='border-bottom:hidden;'>$row[$i]</td>";
				endforeach;$str.="
						</tr>";
				endforeach;$str.="
		</tbody>
		</table>
	</div>

		";
		return $str;

	}

	function createNormalTable(){

		$this->prePopulateProcessing();
		$str= ("

		<div id = ''>
		<form method=post action=''>
			<table  id=\"$this->table_name\"  cellpadding=\"0\" cellspacing=\"0\" border=\"$this->border\" class=\"display\" summary = \"table\" >
				<div id = 'caption_$this->table_name' > Query Results </div>
						<thead>
				<tr >");
		foreach ($this->headerOrder as $i):
		$name = $this->headers[$i]; $str.= "
					<th >$name</th>";
		endforeach;
		$str .="</tr></thead><tbody>
			";
		foreach ($this->data as $row): $str .="
				<tr class=\"gradeC odd\">";
		foreach ($this->headerOrder as $i):$str.="
					<td >$row[$i]</td>";
		endforeach;$str.="
				</tr>";
		endforeach;$str.="
			</tbody>
			</table>
			</form>
		</div>

		";

		return $str;

	}

	function loadKpi( $family_id ){

		$this->kpi = new KpiModule();

		$this->kpi->kpiController->setFamilyId( $family_id );

		$this->kpi->kpiController->loadMeasureSelectionValueHash();
		$this->kpi->kpiController->loadMeasureValueHash();
		$this->kpi->kpiController->loadSelectionHash();
		$this->kpi->kpiController->loadMeasureHash();

		$this->kpi->kpiController->kpiModel->getHashResult('name', 'type');
		$this->kpi_selection_hash = $this->kpi->kpiController->kpiModel->getSelectionCriteriaDetailsByType(  );

	}

	function createKpiTable( $table_id = false, $family_id = false, $measure_id = false ){

		$this->prePopulateProcessing();
		$str= ("

		<div id = 'kpi_table_$this->table_name' >
		<form method=post action=''>
			<table  id= '$this->table_name'  cellpadding= '0' cellspacing= '0' border = '0' class = 'display' style = 'margin-left: 0px; width: 1276px; '>
						<thead>
				<tr >");
		foreach ($this->headerOrder as $i):

			$name = $this->headers[$i];
			if( $this->header_custom_hash ){

				$custom_name = $this->header_custom_hash[$name];
				if($custom_name)
					$name = $custom_name;
			}

			$str.= "<th  >$name</th>";
		endforeach;
		$str .="</tr></thead><tbody>
			";

		foreach ($this->data as $row):

			$row_name = $row['selection_criteria'];
			$class = $this->kpi_selection_hash[$row_name];
			if( isset($this->kpi_type_selection_field) && $this->kpi_type_selection_field != 'all'  )
				if( $class != $this->kpi_type_selection_field )
					continue;

			$str .="<tr class=\"gradeC odd $class\" >";

			foreach ($this->headerOrder as $i):

				list( $class_to_use, $symbol )= $this->getClassByTableType( $table_id, $row, $i, $family_id, $measure_id );
				$name = $this->headers[$i];
				$str.="<td id = '$name' class = '$class_to_use' >$row[$i] $symbol</td>";
			endforeach;$str.="
				</tr>";

		endforeach;$str.="
			</tbody>
			</table>
			</form>
		</div>
		";

		return $str;

	}

	function getClassByTableType( $table_id, $row, $row_count, $family_id, $measure_id = false ){

		if( $table_id == 1 ){

			$skip_header = 'selection_criteria';
			$measure_id = $row_count;
		}elseif( $table_id == 2 ){

			$skip_header = 'measure_id';
			$measure_id = $row[$skip_header];

		}elseif( $table_id == 3 ){

			$skip_header = 'selection_criteria';
		}


		else
			return 'Black';

		if( $row_count != $skip_header ){

			list( $class_to_use, $symbol ) = $this->getClassToUse( $row[$row_count], $measure_id, $row[$skip_header], $family_id );
		}else
			$class_to_use = '';

		return array( $class_to_use, $symbol );
	}

	function getSelectionType( $selection_value, $family_id ){

		$this->kpi->getClassTypeBySelectionType( $selection_value, $family_id );
	}

	function getClassToUse( $measure_value, $measure_id, $selection_type, $family_id ){

		list( $value, $symbol )= $this->kpi->getMeasurePerformanceMetricsByValue( $measure_value, $measure_id, $selection_type, $family_id );

		$value = ( int ) $value;

		if( $value == 1 )
			$class = 'Pass';
		elseif( $value == 0 )
			$class = 'Fail';
		elseif( $value == -1 )
			$class = 'Average';
		else
			$class = 'Black';

		return array( $class, $symbol);
	}

	function populateOverall($col,$key,$value){
		if(!is_array($this->overall[$col]))
			$this->overall[$col] = array();
		$this->overall[$col][$key] = $value;
	}

	/**
	 * Gives the sum of all columns on group by basis.
	 *
	 * @param $ignore_headers
	 * @param $col : The Column on which the group by has to be introduced to get the sum
	 * @param $ColumnValue : The values on which group by will be done. Present in the passed column
	 * @return array $sum
	 */
	function getColumnsSumsByRowName($ignore_headers = NULL,$col,$ColumnValue = array()){

		$this->prePopulateProcessing();

		//use the table headers by default
		$sumheaders = $this->headerOrder;

		if($ignore_headers == NULL)
			$ignore_headers = array();

		$sum = array();
		$ColumnValue = !is_array( $ColumnValue ) ? array() : $ColumnValue ;
		foreach($ColumnValue as $cv){
			foreach($this->data as $row){
				if($cv == $row[$col])
					foreach($sumheaders as $h){
						//ignore the header if it is present the ignore headers list
						if(in_array($h, $ignore_headers))
							continue;

						$sum[$cv][$h] += strip_tags($row[$h]);
					}
			}
		}
		//populate overall
		if($this->use_accordion){
			foreach($ColumnValue as  $value){

				$sum[$value] = !is_array( $sum[$value] ) ? array() : $sum[$value] ;
				foreach($sum[$value] as $key => $cs)
					$this->populateOverall($value,$key,$cs);
			}
		}
		return $sum;
	}

	/**
	 * Returns a Row of of values. Each value is a Sum of the whole column for the respective header.
	 * Uses the table data's headerOrder
	 * NOTE : Should be called only when the data is present	 *
	 * @param $ignore_headers Any Headers which should be ignored
	 * @return A row of Column sums, one for each of the headers
	 */
	function getColumnsSums($ignore_headers = NULL){

		$this->prePopulateProcessing();

		//use the table headers by default
		$sumheaders = $this->headerOrder;

		if($ignore_headers == NULL)
			$ignore_headers = array();

		$sum = array();
		foreach($this->data as $row){

			foreach($sumheaders as $h){
				//ignore the header if it is present the ignore headers list
				if(in_array($h, $ignore_headers))
					continue;

				$sum[$h] += strip_tags($row[$h]);

			}

		}

		return $sum;
	}

	function getColumnsAverage($ignore_headers = NULL){

		$this->prePopulateProcessing();

		//use the table headers by default
		$sumheaders = $this->headerOrder;

		if($ignore_headers == NULL)
			$ignore_headers = array();

		$sum = array();
		foreach($this->data as $row){

			foreach($sumheaders as $h){
				//ignore the header if it is present the ignore headers list
				if(in_array($h, $ignore_headers))
					continue;

				$sum[$h] += strip_tags($row[$h]);

			}

		}
		$row_count = sizeof ($this->data);
		echo ("COUNT:".$row_count);
		foreach ($sum as &$column) {
			$column = round($column/$row_count, 2);
		}

		return $sum;
	}

	function data(){
		return $this->data;
	}

	/**
	 * Order the data in the table
	 * @param $column_key The header of the column to sort
	 * @param $type Whether its a numeric or alphanumeric. Accepts SORT_NUMERIC, SORT_STRING(default)
	 * @param $order Ascending or Descending. Accepts SORT_ASC (default), SORT_DESC
	 */
	function orderBy($column_key, $type = SORT_STRING, $order = SORT_ASC){

		if(count($this->data) > 0){
			$sorting_array = array();
			foreach($this->data as $row){
				$sorting_array[$column_key][] = $row[$column_key];
			}

			array_multisort($sorting_array[$column_key], $order, $type, $this->data);
		}
	}

	/**
	 * Reorders headings based on the new order provided. The new order should contain
	 * all the column Indices that we want to appear. Eg., if the headers were
	 * array('h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3') ... we can porovide the new order
	 * array('h3', 'h2') and we will only show
	 * H3, and H2
	 */
	function reorderColumns(array $newOrder) {
		$this->headerOrder = $newOrder;
	}
	/**
	 * Beautify all timestamps for a particular column
	 * @params $colindex column number whose time format is to be changed
	 * @params $format new time format
	 * @return void
	 */
	function beautifyTimestamp($colindex, $format) {
		foreach($this->data as &$row) {
			$row[$colindex] = date_format(date_create($row[$colindex]), $format);
		}

	}
	/**
	 * Makes the column - Human readable
	 * code used:-
	 * 		1 - Yes
	 * 		0 - No
	 * @params $colindex column number which has to be humanified
	 */
	function humanifyColumn($colindex) {
		foreach($this->data as &$row) {
			if ($row[$colindex] == 1)
				$row[$colindex] = 'Yes';
			else if ($row[$colindex] == 0)
				$row[$colindex] = 'No';
		}
	}

	/**
	 * Take a table and horizontaly expand one the column 'key' setting the 'value' for the the row 'id'
	 *table = new Table();
	 *table->make2D( ... );
	 */
	function make2D ($id, $key, $value) {
		$count = sizeof($this->headers);
		foreach ($this->data as $row) {

			if (!in_array($row[$key], $this->headers))
				$this->addHeader($row[$key], $row[$key]);
		}
		$this->removeHeader($key);
		$this->removeHeader($value);
		$new_data = array();
		$new_row = array();
		if (sizeof($this->data)>0) $new_row[$id] = $this->data[0][$id];
		foreach ($this->data as $row) {
			if ($row[$id] != $new_row[$id]) {
				array_push($new_data, $new_row);
				$new_row = array ();
				$new_row[$id] = $row[$id];
			}
			$new_row[$row[$key]] = $row[$value];
		}
		array_push($new_data, $new_row);
		$this->data = $new_data;
	}

	function addCheckbox($column,$button = false, $download_option = true,$only_download = false,$add_checkall = true) {

		if($button == false )
			$button = "Go";

		$this->checkbox_column = $column;
		$submit = $this->name.'_checkbox_submit';
		foreach ($this->data as &$row) {
			$value = $row[$column];
			$name = $this->name.'checkbox_'.$column.$value;
			if(strlen($row[$column]) == 0)
				continue;
			if(!$only_download){
				if (isset($_POST[$name]))
					$row[$column] = "<input type=checkbox name=\"$name\" value=\"$value\" checked class = 'check_box' /> $value ";
				else
					$row[$column] = "<input type=checkbox name=\"$name\" value=\"$value\" class = 'check_box' /> $value ";
			}
		}
		$submit_row = array();

		if($download_option)
			$download_option = "~Download as Excel?<input type=checkbox name=$this->name'_download'><br>";
		else
			$download_option = "";

		if( $add_checkall )
			$check_str = $this->addCheckAllOption( false );
		else
			$check_str = "";

		$submit_row[$column] = "$check_str<br/>$download_option<input type=submit name=\"$submit\" value=\"$button\" />";

		array_push($this->data, $submit_row);
	}

	function checkboxSubmitted () {
		$submit = $this->name.'_checkbox_submit';
		return isset($_POST[$submit]);
	}

	function getCheckedValues () {
		$column = $this->checkbox_column;
		$values = array();
		foreach ($this->data as $row) {
			$value = trim(strip_tags($row[$column]));
			$checkbox = $this->name.'checkbox_'.$column.$value;
			if (isset($_POST[$checkbox]))
				array_push ($values, $_POST[$checkbox]);
		}
		return $values;
	}

	function isTobeDownloaded () {
		return isset($_POST[$this->name.'_download']);
	}

	function addHiddenbox($column,$value){

		$name = $this->name.'_hidden_box';

		$str = "<input type='hidden' id='$name' name='$name' value='$value' />";

		array_push($this->data, array($column => $str));


	}

	function addCheckAllOption( $value = false ){

		$name = $this->name.'_check_option';

		if( $value == true )
			$str = "<input type = 'checkbox' name = '$name' id='$name' checked > Check/UnCheck All </input>";
		else
			$str = "<input type = 'checkbox' name = '$name' id='$name' > Check/UnCheck All </input>";

		$this->jsMod->setCheckAllOptionsForTable( $name , 'check_box' );

		return $str;
	}

	function addSelectionBox($column, $value, $attrs = array()){

		$name = $this->name.'_selection_box';


		if (!isset($attrs['list_options']))
			$attrs['list_options'] = $value;

		$str = "";

		$attr_str = "";
		if (is_array($attrs)) {
			//leave out the `list_options` and `help_text` attribute
			foreach ($attrs as $k => $v) {
				if ($k == 'list_options') continue;
				if ($k == 'help_text') continue;
				if ($k == 'richtext') continue;
				$attr_str .= " $k='$v' ";
			}
		}

		if (isset($f['attrs']['multiple'])) $name = $name."[]";
		$str .= "<select id='$name' name='$name' $attr_str >\n";
		if (is_array($attrs['list_options'])) {
			$assoc = Util::is_assoc($attrs['list_options']);

			foreach ($attrs['list_options'] as $k => $v) {
			//if not an assoc, the option name should be the same as the value
				$label = $assoc ? $k : $v;
				$selected = ( is_array($value) ? in_array($value, $v) : ($value == $v) ) ? " selected='selected' " : '';

				$str .= "<option value='$v' $selected>$label</option>\n";
			}
		}
		$str .= "</select>";

		array_push($this->data, array($column => $str));
	}

	function getSelectionBoxValue(){
		return $_POST[$this->name.'_selection_box'];
	}

	function getHiddenBoxvalue(){
		return $_POST[$this->name.'_hidden_box'];
	}
}
?>
