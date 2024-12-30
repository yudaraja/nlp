import sys
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import nltk
import json

nltk.download('stopwords')
nltk.download('punkt')

def preprocess(text):
    from nltk.corpus import stopwords
    stop_words = set(stopwords.words('indonesian'))
    tokens = nltk.word_tokenize(text.lower())
    filtered_tokens = [word for word in tokens if word.isalnum() and word not in stop_words]

    # Stemming
    stemmer_factory = StemmerFactory()
    stemmer = stemmer_factory.create_stemmer()
    stemmed_tokens = [stemmer.stem(word) for word in filtered_tokens]

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
    processed_answer = preprocess(answer)
    processed_key_answer = preprocess(key_answer)

    # TF-IDF Calculation
    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform([processed_key_answer['stemmed'], processed_answer['stemmed']])
    cos_sim = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])

    # Convert similarity to percentage
    score = int(cos_sim[0][0] * 100)

    # Get TF-IDF values for the documents
    tfidf_values = {
        'key_answer_tfidf': dict(zip(vectorizer.get_feature_names_out(), tfidf_matrix[0].toarray()[0])),
        'answer_tfidf': dict(zip(vectorizer.get_feature_names_out(), tfidf_matrix[1].toarray()[0]))
    }

    # Prepare result
    result = {
        'score': score,
        'cosineSimilarity': cos_sim[0][0] * 100,  # Add cosine similarity
        'threshold': 80,  # Threshold for similarity, adjust as needed
        'isAboveThreshold': score >= 80,  # Check if score is above the threshold
        'processedAnswer': processed_answer,
        'processedKeyAnswer': processed_key_answer,
        'tfidf_values': tfidf_values
    }

    # Output as JSON
    print(json.dumps(result))
