export function loadYandexMap(key, delay, callback) {

  if (typeof ymaps === "undefined") {
    setTimeout(() => {
      let script = document.createElement("script");
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