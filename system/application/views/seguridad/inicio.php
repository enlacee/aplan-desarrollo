<script type="text/javascript" src="<?php echo base_url();?>js/domwindow.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/maestros/tipocambio.js"></script>
<table class="fuente8" width="93%" border="0" align="center">
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>		
	<?php foreach($lista as $value){?>
		<tr>
		<td>&nbsp;</td>
		<td>
			<!-- <div class="error_log">
				<span class="icon_error"></span>
				<?php //echo $value[3].' EN '.$value[6].' - Fecha : '.$value[7];?>
			</div> -->
			<div class="error_log2">
				<table class="fuente8" cellspacing="0" cellpadding="3" border="0" >
					<tr class="table_par">
						<td><?= $value[3]; ?></td>
						<td><?= $value[6]; ?></td>
						<td><?= $value[7]; ?></td>
					</tr>
				</table>
			</div>
		</td>
		<td>&nbsp;</td>
	</tr>
	<?php }?>
	
</table>
<table class="fuente8" width="93%" border="0" align="center">
  <tr height="90px">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>	  
  <tr height="200px">
	<td>&nbsp;</td>
	<td><div align="center"><img src="<?php echo base_url();?>images/logo_central.jpg" width="496" height="180" /></div></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td><div align="center" class="Estilo6">Sistema MPS</div></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td><div align="center" class="Estilo6">Versi&oacute;n 1.0 </div></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td><div align="center" class="Estilo6">Copyright &copy; 2012 AVC Consulting</div></td>
	<td>&nbsp;</td>
  </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><table width="50%" border="0" align="center">
		<tr>
		  <td><div align="center"><span class="Estilo5">Resoluci&oacute;n Optima 1024 x 768 p&iacute;xeles  </span></div></td>
		</tr>
	  </table></td>
	  <td>&nbsp;</td>
	</tr>
	<tr>
	  <td height="27">&nbsp;</td>
	  <td><table width="50%" border="0" align="center">
		<tr>
		  <td width="37%"><div align="right"></div></td>
		  <td width="63%"><a href="http://www.avcconsult.com/" target="_blank"><span class="Estilo5">www.avcconsult.com</span></a></td>
		</tr>
	  </table></td>
	  <td>&nbsp;</td>
	</tr>
	<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
</table>


