<div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex flex-column align-items-start pb-0">
                <div class="avatar bg-rgba-primary p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-users text-warning font-medium-5"></i>
                    </div>
                </div>
                <h2 class="text-bold-700 mt-1">{{$data['countPC']}}</h2>
                <p class="mb-0">Posibles clientes</p>
            </div>
            <div class="card-content">
                <div id="line-area-chart-1"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex flex-column align-items-start pb-0">
                <div class="avatar bg-rgba-success p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-users text-success font-medium-5"></i>
                    </div>
                </div>
                <h2 class="text-bold-700 mt-1">{{$data['countClientes']}}</h2>
                <p class="mb-0">Clientes</p>
            </div>
            <div class="card-content">
                <div id="line-area-chart-2"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex flex-column align-items-start pb-0">
                <div class="avatar bg-rgba-danger p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                    </div>
                </div>
                <h2 class="text-bold-700 mt-1">{{$data['countVendedores']}}</h2>
                <p class="mb-0">Vendedores</p>
            </div>
            <div class="card-content">
                <div id="line-area-chart-3"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header d-flex flex-column align-items-start pb-0">
                <div class="avatar bg-rgba-warning p-50 m-0">
                    <div class="avatar-content">
                        <i class="feather icon-package text-warning font-medium-5"></i>
                    </div>
                </div>
                <h2 class="text-bold-700 mt-1">{{$data['countRepartidores']}}</h2>
                <p class="mb-0">Repartidores</p>
            </div>
            <div class="card-content">
                <div id="line-area-chart-4"></div>
            </div>
        </div>
    </div>
</div>