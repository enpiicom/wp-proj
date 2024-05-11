class SampleClass {
    constructor(
        public readonly text1: string,
        readonly number1: number,
        protected number2: number, // accessible within class & subclasses
        private text2: string // accessible within class
    ) {
        this.text1 = text1;
        this.number1 = number1;
        this.number2 = number2;
        this.text2 = text2;
    }

    getText() {
        return `${this.text1} is a ${this.number1}`;
    }
}

const SampleText = new SampleClass("Hello", 1, 2, "World");
console.log(SampleText.text1);
console.log(SampleText.getText());
