import {watch} from 'vue';
import {Inertia} from '@inertiajs/inertia';
 
export function usePrevalidate(form, {method, url}) {
  let touchedFields = new Set();
  let needsValidation = false;
  form.passedFields = {};
 
  watch(() => form.data(), (newData, oldData) => {
    let changedFields = Object.keys(newData).filter(field => newData[field] !== oldData[field]);
 
    touchedFields = new Set([...changedFields, ...touchedFields]);
 
    needsValidation = true;   
  });
 
  function validate() {
    Inertia.visit(url, {
      method: method,
      data: {
        ...form.data(),
        prevalidate: true,
      },
      preserveState: true,
      preserveScroll: true,
      onSuccess:() =>{
        form.clearErrors();        
      },
      onError: (errors) => {               
        Object.keys(errors)
          .filter(field => !touchedFields.has(field))
          .forEach(field => delete errors[field]);        
        
        form.passedFields = {};
        Array.from(touchedFields)
        .filter(field => !Object.keys(errors).includes(field))
        .forEach(field => {
            form.passedFields[field] = true;           
        });
        
        form.clearErrors().setError(errors);
      },
    });
  }
 
  return {validate};
}