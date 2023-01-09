<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Registro Único de la Federación</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Datos Personales</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="pl-4 pt-4 tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

        <form action=""  data-sm-action="<?php echo SmRouterHelper::build_route_name('home', 'ruf_prueba'); ?>" class="needs-validation"  novalidate >
            <div class="form-group">
                <label for="inputRUF">Registro Único de la Federación (RUF)*:</label>
                <input type="number" class="form-control" id="inputRUF" name="query[ruf]" aria-describedby="emailHelp" placeholder="Ingresa tu Registro Único de la Federación" required>
                <div class="invalid-feedback">
                    Registro Único de la Federación es incorrecto
                </div>                              
            </div>
            <button type="submit" class="btn btn-primary fmffmanager-btn">Buscar</button>
        </form>

    </div>
    <div class="pl-4 pt-4 tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <form action=""  data-sm-action="<?php echo SmRouterHelper::build_route_name('home', 'ruf_prueba'); ?>" >
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="input_nombre">Nombre(s):</label>
                    <input type="text" class="form-control" id="input_nombre" name="query[personal][name]" placeholder="Ingresa tu nombre(s)">
                </div>
                <div class="form-group col-md-6">
                    <label for="input_AP">Apellido Paterno:</label>
                    <input type="text" class="form-control" id="input_AP" name="query[personal][last_name]" placeholder="Ingresa tu apellido paterno">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="input_AM">Apellido Materno:</label>
                    <input type="text" class="form-control" id="input_AM" name="query[personal][middle_name]" placeholder="Ingresa tu apellido materno">
                </div>
                <div class="form-group col-md-6">
                    <label for="input_CURP">CURP:</label>
                    <input type="text" class="form-control" id="input_CURP" name="query[personal][CURP]" placeholder="Ingresa tu CURP">
                </div>
            </div>

            
            <button type="submit" class="btn btn-primary fmffmanager-btn">Buscar</button>
        </form>
    </div>
</div>