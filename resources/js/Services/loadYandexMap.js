export function loadYandexMap(key, delay, callback) {
  if (typeof ymaps === "undefined") {    
    setTimeout(() => {      
      let script = document.getElementById('api_maps_yandex_ru');
      if (script !== null) return;
      script = document.createElement("script");
      script.id = "api_maps_yandex_ru";
      script.type  = "text/javascript";
      script.src   = "https://api-maps.yandex.ru/2.1/?apikey="+key+"&lang=ru_RU";
      document.head.appendChild(script);
      script.addEventListener('load', () => {
        ymaps.ready(()=> {            
          callback();
        });
      });
    }, delay);              
  } else {
    ymaps.ready(()=> {            
      callback();
    });
  }    
  return true;
}