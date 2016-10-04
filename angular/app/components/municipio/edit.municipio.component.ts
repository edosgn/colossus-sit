// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {DepartamentoService} from '../../services/departamento/departamento.service';
import {MunicipioService} from "../../services/municipio/municipio.service";
import {Municipio} from '../../model/municipio/Municipio';
 
// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'default',
    templateUrl: 'app/view/municipio/edit.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService ,DepartamentoService,MunicipioService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class MunicipioEditComponent implements OnInit{ 
	public errorMessage;
	public municipio : Municipio;
	public id;
	public respuesta;
	public municipios;
	public departamentos;

	constructor(
		private _loginService: LoginService,
		private _DepartamentoService: DepartamentoService,
		private _MunicipioService: MunicipioService,
		private _route: ActivatedRoute,
		private _router: Router
		
		){}

	ngOnInit(){	
		
		
		this.municipio = new Municipio(null,null, "", null);
		let token = this._loginService.getToken();
		this._DepartamentoService.getDepartamento().subscribe(
				response => {
					this.departamentos = response.data;
				}, 
				error => {
					this.errorMessage = <any>error;

					if(this.errorMessage != null){
						console.log(this.errorMessage);
						alert("Error en la petición");
					}
				}
			);

			this._route.params.subscribe(params =>{
				this.id = +params["id"];
			});

			this._MunicipioService.showMunicipio(token,this.id).subscribe(

						response => {
							let data = response.data;
							this.municipio = new Municipio(data.id,data.departamento.id, data.nombre, data.codigoDian);
						},
						error => {
								this.errorMessage = <any>error;

								if(this.errorMessage != null){
									console.log(this.errorMessage);
									alert("Error en la petición");
								}
							}

					);
	  
	} 


	onSubmit(){

		let token = this._loginService.getToken();
		console.log(token);

		this._MunicipioService.editMunicipio(this.municipio,token).subscribe(
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


}





