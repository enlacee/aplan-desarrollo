<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/compras/orden.js"></script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
			<div id="tituloForm" class="header"><?php echo $titulo;?></div>
            <div id="frmBusqueda">
				<table class="fuente8" width="100%" cellspacing="0" cellpadding="5" border="0">
				  <tr>
					<td width="8%" >N&uacute;mero</td>
					<td width="20%">
					 <input name="numero" id="numero" type="text" class="cajaGeneral cajaSoloLectura"size="10" maxlength="10" readonly="readonly" value="0016221" />
					<td width="8%">Fecha de Inicio</td>
					<td width="18%">
						<input NAME="fecha" id="fecha" type="text" class="cajaGeneral cajaSoloLectura" value="14/08/2012" size="10" maxlength="10" readonly="readonly" />
						<img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url();?>images/calendario.png" />
							<script type="text/javascript">
								Calendar.setup({
									inputField     :    "fecha",      // id del campo de texto
									ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
									button         :    "Calendario1"   // el id del botón que lanzará el calendario
								});
							</script>
					</td>
					<td width="8%">Fecha de Fin</td>
					<td width="18%">
						<input NAME="fecha" id="fecha" type="text" class="cajaGeneral cajaSoloLectura" value="31/08/2012" size="10" maxlength="10" readonly="readonly" />
						<img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url();?>images/calendario.png" />
							<script type="text/javascript">
								Calendar.setup({
									inputField     :    "fecha",      // id del campo de texto
									ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
									button         :    "Calendario1"   // el id del botón que lanzará el calendario
								});
							</script>
					</td>
				  </tr>
				  <tr>
					<td>Producto Gen&eacute;rico</td>
					<td valign="middle">
						 <input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" value="VD0271RAI" onkeypress="return numbersonly(this,event,'.');" />
					</td>
					<td>Taller </td>
					<td><select name="moneda" id="moneda" class="comboMedio"><option>TUNKARS SAC</option></select></td>
					<td>Destino</td>
					<td><select name="presupuesto" id="presupuesto" class="comboMedio"  onchange="obtener_detalle_presupuesto()" ><option>ATELIER MIRAFLORES</option></select></td>
				  </tr>
				  <tr>
					<td>
						Cantidad Planificada
					</td>
					<td>
						<input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" value="176" onkeypress="return numbersonly(this,event,'.');" />
					</td>
					<td>
						Cantidad Pendiente
					</td>
					<td id="show_cotizaciones">
						<input type="text" name="ruc_cliente" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" value="176" onkeypress="return numbersonly(this,event,'.');" />
					</td>
				  </tr>
				</table>
				<div id="frmBusqueda" style="height:250px; overflow: auto">
				<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="1" ID="Table1">
						<tr class="cabeceraTabla">
								<td width="3%"><div align="center">&nbsp;</div></td>
								<td width="4%"><div align="center">ITEM</div></td>
								<td width="15%"><div align="center">C&Oacute;DIGO</div></td>
								<td><div align="center">DESCRIPCI&Oacute;N</div></td>
								<td width="10%"><div align="center">COLOR</div></td>
								<td width="10%"><div align="center">TALLA</div></td>
								<td width="10%"><div align="center">CANTIDAD</div></td>
						</tr>
				</table>
			
				<div  >
					<table id="tblDetalleOcompra" class="fuente8" width="100%" border="1">
						  <tr class="">
							   <td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onClick="eliminar_producto_ocompra();"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
							   <td width="4%"><div align="center">1</div></td>
							  <td width="15%"><div align="center">VD0271RAIAZUUN</div></td>
							  <td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri[]" id="proddescri[]" value="VES MB SM ESCOTE V VD0271RAI AZUL UNICA" /></div></td>
							  <td width="10%"><div align="center">AZU</div></td>
							  <td width="10%"><div align="center">UN</div></td>
							  <td width="10%"><div align="center">
								<input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[]" id="prodprecio[]" value="40" readonly="readonly" />
							  </div></td>
						  </tr>
						   <tr class="">
							   <td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onClick="eliminar_producto_ocompra();"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
							   <td width="4%"><div align="center">2</div></td>
							  <td width="10%"><div align="center">VD0271RAINEGUN</div></td>
							  <td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri[]" id="proddescri[]" value="VES MB SM ESCOTE V VD0271RAI NEGRO UNICA" /></div></td>
							  <td width="10%"><div align="center">NEG</div></td>
							  <td width="10%"><div align="center">UN</div></td>
							  <td width="10%"><div align="center">
									  <input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[]" id="prodprecio[]" value="55" readonly="readonly" />
							  </div></td>
						  </tr>
						   <tr class="">
							   <td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onClick="eliminar_producto_ocompra();"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
							   <td width="4%"><div align="center">3</div></td>
							  <td width="10%"><div align="center">VD0271RAIROJUN</div></td>
							  <td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri[]" id="proddescri[]" value="VES MB SM ESCOTE V VD0271RAI ROJO UNICA" /></div></td>
							  <td width="10%"><div align="center">ROJ</div></td>
							  <td width="10%"><div align="center">UN</div></td>
							  <td width="10%"><div align="center">
									  <input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[]" id="prodprecio[]" value="40" readonly="readonly" />
							  </div></td>
						  </tr>
						   <tr class="">
							   <td width="3%"><div align="center"><font color="red"><strong><a href="javascript:;" onClick="eliminar_producto_ocompra();"><span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span></a></strong></font></div></td>
							   <td width="4%"><div align="center">4</div></td>
							  <td width="10%"><div align="center">VD0271RAIVDEUN</div></td>
							  <td><div align="left"><input type="text" class="cajaGeneral" style="width:335px;" maxlength="250" name="proddescri[]" id="proddescri[]" value="VES MB SM ESCOTE V VD0271RAI VERDE ESMEP" /></div></td>
							  <td width="10%"><div align="center">VDE</div></td>
							  <td width="10%"><div align="center">UN</div></td>
							  <td width="10%"><div align="center">
									  <input type="text" size="5" maxlength="10" class="cajaGeneral cajaSoloLectura" name="prodprecio[]" id="prodprecio[]" value="41" readonly="readonly" />
							  </div></td>
						  </tr>
					</table>
				</div>
		</div>
				<div style="margin-top:20px; text-align: center">
					<a href="javascript:;" id="" onclick="javascript:history.back();"><img src="<?php echo base_url();?>images/botonaceptar.jpg" width="85" height="22" class="imgBoton" ></a>
					<a href="javascript:;" id="" onclick="javascript:history.back();"><img src="<?php echo base_url();?>images/botoncancelar.jpg" width="85" height="22" class="imgBoton"></a>
					
				</div>
				<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>">
				<input type="hidden" name="modo" id="modo" value="<?php echo $modo;?>">
				<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
            </div>
        </div>
    </div>
</div>