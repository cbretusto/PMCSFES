<html>
<head>
<style>

th,td {
    padding: 10px;
}

td {
    padding: 5px;
}

</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>&nbsp;</th>
			</tr>

			<!-- Table Headers -->
			<tr style="border: 1px solid black;">
				<th>&nbsp;</th>
				<th colspan="6" rowspan="2" style="text-align: center; vertical-align: center; font-size: 24pt;">PRICON MICROELECTRONICS, INC.</th>
				<th colspan="5" rowspan="2" style="text-align: center; vertical-align: center; font-size: 14pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold;">Monitoring of Facility Equipment</th>
			</tr>

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>	
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>							
			</tr>

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>	
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>							
			</tr>

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th colspan="4" style=" ont-family:'Arial'; background-color: #bfbfbf;">Equipment:</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>							
			</tr>

			<!-- Table Headers -->

			@for($f = 0; $f < count($data); $f++ )
			<tr>
				<th>&nbsp;</th>
				<th colspan="4" style="font-family:'Arial'; font-weight: bold">{{ $data[$f]->checksheet_name }}</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>					
			</tr>
			@endfor

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>	
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>								
			</tr>

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th colspan="4" style=" ont-family:'Arial'; background-color: #bfbfbf;">Date Monitored:</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>							
			</tr>

			<!-- Table Headers -->

			@for($g = 0; $g < count($data); $g++ )
			<tr>
				<th>&nbsp;</th>
				<th colspan="4" style="font-family:'Arial'; font-weight: bold">{{ $data[$g]->date_inspected }}</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>				
			</tr>
			@endfor

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>	
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>	
				<th>&nbsp;</th>										
			</tr>

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th rowspan="3" width="8" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Item <br> No.</th>
				<th rowspan="3" width="22" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Control Number</th>
				<th rowspan="3" width="22" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Classification</th>				
				<th rowspan="3" width="22" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Location</th>
				<th colspan="6" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Physical Condition</th>		
				<th rowspan="3" width="30" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">REMARKS</th>					
			</tr>	

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th rowspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 10pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Lever</th>	
				<th rowspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 10pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Hose and <br> Nozzle</th>		
				<th rowspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 10pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">CYL. Tank</th>	
				<th colspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Press Gauge</th>	
				<th rowspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 10pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Capacity <br> ( LBS )</th>						
			</tr>				

			<tr>
				<th>&nbsp;</th>	
				<th width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 10pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf; border: 1px solid black">Below 195 PSI</th>			
				<th width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 10pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf; border: 1px solid black">195 PSI</th>																
			</tr>
			<!-- Table Data -->				

			@for($h = 0; $h < count($data); $h++)
				@for($i = 0; $i < count($data[$h]->criteria_details_fe); $i++)		

			<tr>
				<td style="text-align: center; vertical-align: center; font-family:'Arial';"></td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black">{{ $i + 1 }}</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black">{{ $data[$h]->criteria_details_fe[$i]->control_number }}</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black">{{ $data[$h]->criteria_details_fe[$i]->classification }}</td>
				<td style="font-family:'Arial'; border: 1px solid black">{{ $data[$h]->criteria_details_fe[$i]->location }}</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_fe[$i]->lever == 1)
					 	✓ 
					@else
						✕
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_fe[$i]->hose_and_nozzle == 1)
					 	✓ 
					@else
						✕
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_fe[$i]->cyl_tank == 1)
					 	✓ 
					@else
						✕
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_fe[$i]->press_gauge == 0)
						✕					 	 
					@else
						
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_fe[$i]->press_gauge == 1)
						✓
					@else
						
					@endif
				</td>	
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black">
					@if( $data[$h]->criteria_details_fe[$i]->capacity == 'N/A')

					@else
						{{ $data[$h]->criteria_details_fe[$i]->capacity }}
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black">
					@if( $data[$h]->criteria_details_fe[$i]->remarks == 'N/A')

					@else
						{{ $data[$h]->criteria_details_fe[$i]->remarks }}
					@endif
				</td>									
			</tr>
				@endfor
			@endfor

			<!-- Table Footer -->	

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>		
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>	
				<td>&nbsp;</td>	
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>	
				<td>&nbsp;</td>							
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>		
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>	
				<td>&nbsp;</td>	
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>	
				<td>&nbsp;</td>								
			</tr>

			<tr>
				<td></td>
				<td colspan="3" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Checked By:</td>
				<td colspan="8" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Noted By</td>
			</tr>

			@for($j = 0; $j < count($data); $j++)
			<tr>
				<td></td>
				<td colspan="3" style="text-align: center; vertical-align: center; font-family:'Arial';">{{ $data[$j]->inspector_details->name }}</td>
				<td colspan="4" style="text-align: center; vertical-align: center; font-family:'Arial';">{{ $data[$j]->supervisor_details->name }}</td>
				<td colspan="4" style="text-align: center; vertical-align: center; font-family:'Arial';">{{ $data[$j]->manager_details->name }}</td>
			</tr>
			@endfor

			<tr>
				<td></td>
				<td colspan="3" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Facility Technician</td>
				<td colspan="4" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Sr. Supervisor</td>
				<td colspan="4" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Facility Manager</td>
			</tr>

		</thead>
	<tbody>

		