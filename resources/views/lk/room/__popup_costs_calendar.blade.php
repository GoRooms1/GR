<div class="popup popup_horizontal popup_white" id="popupCostsCalendar" data-url-prefix="lk">
  <input type="hidden" name="cost_id">
  <img src="{{ asset('img/lk/close.png') }}" alt="close" class="close-this">
  <h2 class="title popup__title">Настрока периодов</h2>  
  <div class="row">
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">C</span>
      <input type="date" class="form-control" id="costs_calendar_date_from">      
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">По</span>
      <input type="date" class="form-control" id="costs_calendar_date_to">      
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">Цена</span>
      <input type="number" class="form-control" id="costs_calendar_value">     
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">Скидка %</span>
      <span type="number" class="form-control" id="costs_calendar_discount"></span>      
    </div>
    <div class="form-group col">
      <span class="h5 d-block text-center text-dark pb-2">&nbsp;</span>
      <button type="button" class="btn btn-outline-secondary w-100" id="addCostCalendar">Добавить</button>
    </div>
  </div>
  <div class="pt-4" id="popupCostsCalendarList">   
  </div>
  <button type="button" class="button popup__bottom popup__button_cost_calendar">Сохранить</button>
</div>