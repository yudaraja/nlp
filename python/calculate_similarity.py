import sys
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import nltk
import json

nltk.download('stopwords')
nltk.download('punkt')

def preprocess(text):
    from nltk.corpus import stopwords # mengimport daftar stopword dari library nltk
    stop_words = set(stopwords.words('indonesian')) # mengambil daftar stopword bahasa indonesia
    tokens = nltk.word_tokenize(text.lower()) # tokenisasi kalimat menjadi kata-kata
    filtered_tokens = [word for word in tokens if word.isalnum() and word not in stop_words] # menghapus kata-kata yang bukan alfabet dan stopword

    # Stemming
    stemmer_factory = StemmerFactory() # membuat objek stemmer
    stemmer = stemmer_factory.create_stemmer() # membuat stemmer bahasa indonesia
    stemmed_tokens = [stemmer.stem(word) for word in filtered_tokens] # stemming kata-kata

    return {
        'tokens': filtered_tokens,
        'stemmed': " ".join(stemmed_tokens),
        'filtered_tokens': filtered_tokens,
        'stemmed_tokens': stemmed_tokens
    }

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print(json.dumps({"error": "Insufficient arguments"}))
        sys.exit(1)

    answer = sys.argv[1]
    key_answer = sys.argv[2]

    # Preprocessing
    processed_answer = preprocess(answer) # memproses jawaban
    processed_key_answer = preprocess(key_answer) # memproses kunci jawaban

    # TF-IDF Calculation
    vectorizer = TfidfVectorizer() # membuat objek tfidf vectorizer
    tfidf_matrix = vectorizer.fit_transform([processed_key_answer['stemmed'], processed_answer['stemmed']]) # menghitung tfidf dari kunci jawaban dan jawaban
    cos_sim = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2]) # menghitung cosine similarity dari kunci jawaban dan jawaban

    # Convert similarity to percentage
    score = int(cos_sim[0][0] * 100)

    # Get TF-IDF values / untuk result
    tfidf_values = {
        'key_answer_tfidf': dict(zip(vectorizer.get_feature_names_out(), tfidf_matrix[0].toarray()[0])),
        'answer_tfidf': dict(zip(vectorizer.get_feature_names_out(), tfidf_matrix[1].toarray()[0]))
    }

    result = {
        'score': score,
        'cosineSimilarity': cos_sim[0][0] * 100,
        'threshold': 80,
        'isAboveThreshold': score >= 80,
        'processedAnswer': processed_answer,
        'processedKeyAnswer': processed_key_answer,
        'tfidf_values': tfidf_values
    }

    print(json.dumps(result))
