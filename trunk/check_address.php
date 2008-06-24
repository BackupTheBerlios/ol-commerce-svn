<?PHP
$postcode = $_POST['postcode'];
$build_input = true;
if ($postcode <> '')
{
	$city = $_POST['city'];
	if ($city <> '')
	{
		$street = $_POST['street'];
		if ($street <> '')
		{
			$last_name = $_POST['last_name'];
			if ($last_name  <>  '')
			{
				$first_name=$_POST['first_name'];
				$fon = $_POST['fon'];
				$fax = $_POST['fax'];
				require_once($dir . 'includes/functions/address_validation.php');
				//IsValidAddress('81', $postcode, $city, $street, $last_name, $fon, $fax, $message);
				IsValidAddress('81', $postcode, $city, $street_address, $last_name, $first_name,$fon, $fax, $message);
				$build_input = false;
			}
		}
	}
}
echo '<html><body><p align="center"><b><font size="4" color="#FF0000">Online Adress-Validierung</font></b></p>';
//W. Kaiser - AJAX
//echo '<form method="POST" action="check_address.php">';
echo olc_draw_form('check_address', olc_href_link('check_address.php'));
//W. Kaiser - AJAX
echo '<table border="0" align="center">';
show_input_field('last_name', 'last_name', $build_input, $last_name);
show_input_field('Vorame', 'first_name', $build_input, $first_name);
show_input_field('Strasse', 'street', $build_input, $street);
show_input_field('Postleitzahl', 'postcode', $build_input, $postcode);
show_input_field('Ort', 'city', $build_input, $city);
show_input_field('Fon', 'fon', $build_input, $fon);
show_input_field('Fax', 'fax', $build_input, $fax);
if (!$build_input)
{
	echo
	'<tr>
				<td colspan="2"><br/><hr/>' .
	str_replace(HTML_NBSP, '', $message) . '<br/><br/><hr/>
			</td>
		</tr>
	';
}
echo '
		</table><p align="center"><input type="submit" value="Absenden" last_name="B1">&nbsp;
		<input type="reset" value="Zurücksetzen" last_name="B2"></p></form></body></html>
		';

function show_input_field($label, $last_name, $build_input, $value)
{
	$field = '<input type="text", size="50", last_name="' .$last_name . '", value="' . $value . '">';
	echo '
		<tr>
			<td>' .
	$label . ':&nbsp;
			</td>
			<td>
				&nbsp;'. $field . '
			</td>
		</tr>
	';
}
?>