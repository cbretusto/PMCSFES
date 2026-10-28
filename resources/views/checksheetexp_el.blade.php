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
				<th colspan="8" rowspan="2" style="text-align: center; vertical-align: center; font-size: 24pt;">PRICON MICROELECTRONICS, INC.</th>
				<th colspan="2" rowspan="2" style="text-align: center; vertical-align: center; font-size: 14pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold;">Monitoring of Facility Equipment</th>
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
				<th colspan="10" style=" font-family:'Arial'; background-color: #bfbfbf;">Equipment:</th>
				<th>&nbsp;</th>
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
				<th colspan="10" style="font-family:'Arial'; font-weight: bold">{{ $data[$g]->checksheet_name }}</th>
				<th>&nbsp;</th>
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
				<th colspan="3" style=" ont-family:'Arial'; background-color: #bfbfbf;">Date Monitored:</th>
				<th>&nbsp;</th>
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
				<th colspan="3" style="font-family:'Arial'; font-weight: bold">{{ $data[$g]->date_inspected }}</th>
				<th>&nbsp;</th>
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
				<th rowspan="4" width="8" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Item</th>
				<th rowspan="4" width="30" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Control Number</th>
				<th rowspan="4" width="30" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Location</th>
				<th colspan="3" width="42" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">REMARKS</th>
				<th colspan="2" rowspan="2" width="36" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Draining of Rechargeable Battery</th>
				<th rowspan="4" width="30" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Inspection Card attached to the unit <br> ✓- updated </th>			
				<th rowspan="4" width="38" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">REMARKS / ACTION TAKEN</th>					
			</tr>	

			<!-- Table Headers -->
			<tr>
				<th>&nbsp;</th>
				<th rowspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Lights - L</th>
				<th rowspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Lights - R</th>
				<th rowspan="2" width="14" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Battery</th>			
			</tr>				

			<tr>
				<th>&nbsp;</th>
				<th rowspan="2" width="18" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Done</th>			
				<th rowspan="2" width="18" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;">Less than <br> 5 min. NG</th>	
			</tr>

			<tr>
				<th>&nbsp;</th>
				<th width="10" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;  border: 1px solid black"> ✓- G <br> ✕ - NG</th>
				<th width="10" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;  border: 1px solid black"> ✓- G <br> ✕ - NG</th>
				<th width="10" style="text-align: center; vertical-align: center; font-family:'Arial'; font-size: 11pt; padding: 10px 10px; margin: 10px 10px; font-weight: bold; background-color: #bfbfbf;  border: 1px solid black"> ✓- G <br> ✕ - NG</th>			
			</tr>	

			<!-- Table Data -->				

			@for($h = 0; $h < count($data); $h++)
				@for($i = 0; $i < count($data[$h]->criteria_details_el); $i++)		

			<tr>
				<td style="text-align: center; vertical-align: center; font-family:'Arial';"></td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black">{{ $i + 1 }}</td>
				<td style="font-family:'Arial'; border: 1px solid black">{{ $data[$h]->criteria_details_el[$i]->control_number }}</td>
				<td style="font-family:'Arial'; border: 1px solid black">{{ $data[$h]->criteria_details_el[$i]->location }}</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_el[$i]->lights_l == 1)
					 	✓ 
					@else
						✕
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_el[$i]->lights_r == 1)
					 	✓ 
					@else
						✕
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_el[$i]->battery == 1)
					 	✓ 
					@else
						✕
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_el[$i]->draining_of_rechargeable_battery == 1)
					 	✓ 
					@else
						
					@endif
				</td>
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_el[$i]->draining_of_rechargeable_battery == 0)
						✕
					@else
						
					@endif
				</td>	
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black; font-weight: bold;">
					@if($data[$h]->criteria_details_el[$i]->inspection_card == 1)
					 	✓ 
					@else
						✕
					@endif
				</td>		
				<td style="text-align: center; vertical-align: center; font-family:'Arial'; border: 1px solid black">
					@if( $data[$h]->criteria_details_el[$i]->remarks == 'N/A')

					@else
						{{ $data[$h]->criteria_details_el[$i]->remarks }}
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
				<td colspan="7" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Noted By</td>
			</tr>

			@for($j = 0; $j < count($data); $j++)
			<tr>
				<td></td>
				<td colspan="3" style="text-align: center; vertical-align: center; font-family:'Arial';">{{ $data[$j]->inspector_details->name }}</td>
				<td colspan="4" style="text-align: center; vertical-align: center; font-family:'Arial';">{{ $data[$j]->supervisor_details->name }}</td>
				<td colspan="3" style="text-align: center; vertical-align: center; font-family:'Arial';">{{ $data[$j]->manager_details->name }}</td>
			</tr>
			@endfor

			<tr>
				<td></td>
				<td colspan="3" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Facility Technician</td>
				<td colspan="4" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Sr. Supervisor</td>
				<td colspan="3" style="text-align: center; vertical-align: center; font-family:'Arial'; font-weight: bold; background-color: #bfbfbf;">Facility Manager</td>
			</tr>

		</thead>
	<tbody>

		