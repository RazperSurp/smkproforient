export function generateRandomString(length, doAllowRepeat = true, doIncludeNumbers = true, doIncludeSpecials = false) {
    let resultString = '';

    const letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    const numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    const specials = ['=', '+', '-', '*', '⁄', '(', ')', ',', '.', '\'', '"', '%', ';', ':', '¬', '&', '|', '>', '<', '_'];

    let alphabet = letters;
    if (doIncludeNumbers) alphabet = alphabet.concat(numbers);
    if (doIncludeSpecials) alphabet = alphabet.concat(specials);

    for (let i = 0; i < length; i++) {

        let symbol;
        let symbolIndex;
        do {
            symbolIndex = Math.floor(Math.random() * (alphabet.length - 1));
            symbol = alphabet[symbolIndex];
        } while (symbol === null);

        if (!doAllowRepeat) alphabet[symbolIndex] = null;

        resultString += symbol;
    }

    return resultString;
}