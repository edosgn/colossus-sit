"use strict";
var Pago = (function () {
    function Pago(id, tramiteId, valor, fechaPago, horaPago, fuente) {
        this.id = id;
        this.tramiteId = tramiteId;
        this.valor = valor;
        this.fechaPago = fechaPago;
        this.horaPago = horaPago;
        this.fuente = fuente;
    }
    return Pago;
}());
exports.Pago = Pago;
//# sourceMappingURL=Pago.js.map