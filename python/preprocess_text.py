import sys
import json
from nltk.corpus import stopwords
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory

# Pastikan NLTK sudah diunduh dan digunakan
import nltk
nltk.download('stopwords')

def preprocess(text):
    # Stop words dalam bahasa Indonesia
    stop_words = set(stopwords.words('indonesian'))

    # Stemming menggunakan Sastrawi
    factory = StemmerFactory()
    stemmer = factory.create_stemmer()

    # Preprocess text: case folding, remove stop words, stemming
    text = text.lower()  # Lowercase
    words = text.split()  # Tokenization

    # Tampilkan hasil tokenisasi sebelum menghapus stop words
    tokens = words

    # Hapus stop words
    words = [word for word in words if word not in stop_words]

    # Tampilkan hasil setelah menghapus stop words
    filtered_tokens = words

    # Stemming
    stemmed_words = [stemmer.stem(word) for word in words]

    return json.dumps({
        'tokens': tokens,
        'filtered_tokens': filtered_tokens,
        'stemmed_words': stemmed_words
    })

if __name__ == '__main__':
    input_text = sys.argv[1]  # Ambil input teks dari argumen
    result = preprocess(input_text)
    print(result)  # Cetak hasil untuk dikirimkan ke Laravel
