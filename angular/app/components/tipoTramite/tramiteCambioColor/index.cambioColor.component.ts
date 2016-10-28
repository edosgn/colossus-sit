// Importar el núcleo de Angular
import {LoginService} from "../../../services/login.service";
import {Component, OnInit,Input,Output,EventEmitter} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {ColorService} from "../../../services/color/color.service";
import {Color} from "../../../model/color/color";
import {Vehiculo} from "../../../model/vehiculo/vehiculo";
import {TramiteEspecificoService} from "../../../services/tramiteEspecifico/tramiteEspecifico.service";
import {TramiteEspecifico} from '../../../model/tramiteEspecifico/TramiteEspecifico';
import {VehiculoService} from "../../../services/vehiculo/vehiculo.service";
import {VarianteService} from "../../../services/variante/variante.service";
import {CasoService} from "../../../services/caso/caso.service";

 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'tramiteCambioColor',
    templateUrl: 'app/view/tipoTramite/cambioColor/index.component.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService,ColorService,TramiteEspecificoService,VehiculoService,VarianteService,CasoService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewTramiteCambioColorComponent implements OnInit{ 
	
	public colores;
	public casos;
	public casoSeleccionado;
	public variantes;
	public varianteSeleccionada;
	public errorMessage;
	public valor;
	public tramiteEspecifico;
	public respuesta;
	public colorSeleccionado = null;
	public varianteTramite = null;
	public casoTramite = null;
	@Input() tramiteGeneralId =null;
	@Input() vehiculo = null;
	@Output() tramiteCreado = new EventEmitter<any>();
	public vehiculo2;
	public datos = {
		'newColor':null,
		'oldColor':null
	};
	

	constructor(
		
		private _TramiteEspecificoService: TramiteEspecificoService, 
		private _VarianteService: VarianteService, 
		private _CasoService: CasoService, 
		private _VehiculoService: VehiculoService, 
		private _loginService: LoginService,
		private _ColorService: ColorService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){

	}


	ngOnInit(){
		let token = this._loginService.getToken();
		this._CasoService.showCasosTramite(token,5).subscribe(
				response => {
					this.casos = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);
		this._VarianteService.showVariantesTramite(token,5).subscribe(
				response => {
					this.variantes = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
		);


		this.tramiteEspecifico = new TramiteEspecifico(null,5,this.tramiteGeneralId,null,null,null);
	
		this._ColorService.getColor().subscribe(
				response => {
					this.colores = response.data;
					this.colorSeleccionado = this.colores[0];
					this.datos.newColor = this.colorSeleccionado.nombre;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);
		this.datos.oldColor=this.vehiculo.color.nombre;

	}



	onChangeColor(event:any){

		for (var i = 0; i < this.colores.length; ++i) {
			if(event == this.colores[i].id) {
				this.colorSeleccionado = this.colores[i];
				this.datos.newColor = this.colorSeleccionado.nombre;
			}
			
		}
		
	}

	enviarTramite(){

		let token = this._loginService.getToken();
		this._TramiteEspecificoService.register2(this.tramiteEspecifico,token,this.datos).subscribe(
			response => {
				this.respuesta = response;
				if(this.respuesta.status=="success") {
					 this.tramiteCreado.emit(true);
				}

			error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});

		this.vehiculo2 = new Vehiculo(
			this.vehiculo.id,
			this.vehiculo.clase.id, 
			this.vehiculo.municipio.id, 
			this.vehiculo.linea.id,
			this.vehiculo.servicio.id,
			this.colorSeleccionado.id,
			this.vehiculo.combustible.id,
			this.vehiculo.carroceria.id,
			this.vehiculo.organismoTransito.id,
			this.vehiculo.placa,
			this.vehiculo.numeroFactura,
			this.vehiculo.fechaFactura,
			this.vehiculo.valor,
			this.vehiculo.numeroManifiesto,
			this.vehiculo.fechaManifiesto,
			this.vehiculo.cilindraje,
			this.vehiculo.modelo,
			this.vehiculo.motor,
			this.vehiculo.chasis,
			this.vehiculo.serie,
			this.vehiculo.vin,
			this.vehiculo.numeroPasajeros,
			this.vehiculo.pignorado,
			this.vehiculo.cancelado
		);

		this._VehiculoService.editVehiculo(this.vehiculo2,token).subscribe(
			response => {
				this.respuesta = response;
			error => {
					this.errorMessage = <any>error;
					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}

		});
		
	}

	onChangeCaso(event:any){
		this.tramiteEspecifico.casoId=event;
		
	}
	onChangeVariante(event:any){
		this.tramiteEspecifico.varianteId=event;
	}
}
