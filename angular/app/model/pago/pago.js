"use strict";
var Pago = (function () {
    function Pago(id, tramiteId, valor, fechaPago, horaPago) {
        this.id = id;
        this.tramiteId = tramiteId;
        this.valor = valor;
        this.fechaPago = fechaPago;
        this.horaPago = horaPago;
    }
    return Pago;
}());
exports.Pago = Pago;
//# sourceMappingURL=Pago.js.map