// Importar el núcleo de Angular
import {Component, OnInit} from '@angular/core';
import { ROUTER_DIRECTIVES, Router, ActivatedRoute } from "@angular/router";
import {LoginService} from '../../services/login.service';
import {Vehiculo} from '../../model/vehiculo/Vehiculo';

// Decorador component, indicamos en que etiqueta se va a cargar la 

@Component({
    selector: 'register',
    templateUrl: 'app/view/ciudadanoVehiculo/new.html',
    directives: [ROUTER_DIRECTIVES],
    providers: [LoginService]
})
 
// Clase del componente donde irán los datos y funcionalidades
export class NewCiudadanoVehiculoComponent {
	public vehiculo: Vehiculo;

	constructor(
		private _loginService: LoginService,
		private _route: ActivatedRoute,
		private _router: Router
		
	){}

	ngOnInit(){
		this.vehiculo = new Vehiculo(null,null,null,null,null,null,null,null,null,"","","","","","","","","","","",null,null);
		
		
	}


	onSubmit(){
	
	}

	
 }
