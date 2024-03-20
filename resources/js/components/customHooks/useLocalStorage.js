import { useState } from "react";
export function useLocalStorage (key, initialValue) {
    const [valorStorage, setValorStorage] = useState(() => {
        try {
            const item = window.localStorage.getItem(key);
            return item ? JSON.parse(item) : initialValue;
        }catch (e) {
            const error = e.message
            return initialValue;
        }
    });
    const setValor = valor => {
        try {
            setValorStorage(valor);
            window.localStorage.setItem(key, JSON.stringify(valor));
        }catch (e) {
            console.error(e)
        }
    }
    return [valorStorage, setValor]
}
