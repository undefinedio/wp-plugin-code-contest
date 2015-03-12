<h1>Contest entries</h1>
<table id="js-entries" class="display" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th>Code</th>
		<th>Naam</th>
		<th>Email</th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th>Code</th>
		<th>Naam</th>
		<th>Email</th>
	</tr>
	</tfoot>

	<tbody>
	<?php
	foreach ( $entries as $entry ) { ?>
		<tr>
			<td><?= $entry->code; ?></td>
			<td><?= $entry->name; ?></td>
			<td><?= $entry->email; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>