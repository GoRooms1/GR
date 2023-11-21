<div class="popup popup_horizontal popup_white" id="popupCostPeriods" data-url-prefix="lk">
<input type="hidden" name="cost_id">
  <img src="{{ asset('img/lk/close.png') }}" alt="close" class="close-this">
  <h2 class="title popup__title">Настрока периодов</h2>  
  <div class="row">
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">C</span>
      <input type="date" class="form-control" id="cost_periods_date_from" min="{{Date('Y-m-d')}}">   
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">По</span>
      <input type="date" class="form-control" id="cost_periods_date_to" min="{{Date('Y-m-d')}}">      
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">Цена</span>
      <input type="number" class="form-control" id="cost_periods_value">     
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">Скидка %</span>
      <span type="number" class="form-control" id="cost_periods_discount"></span>
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">&nbsp;</span>
      <button type="button" class="btn btn-outline-secondary w-100" id="addCostPeriod">Добавить</button>
    </div>
  </div>
  <div class="pt-4" id="popupCostPeriodsList">   
  </div>
  <button type="button" class="button popup__bottom popup__button_cost_periods">Сохранить</button>
</div>