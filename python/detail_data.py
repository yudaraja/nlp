# filepath: /d:/Laravel/nlp/python/calculate_similarity.py
import sys
import json
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import asyncio
if sys.platform == 'win32':
    asyncio.set_event_loop_policy(asyncio.WindowsSelectorEventLoopPolicy())

def preprocess(text):
    # Add your preprocessing steps here (e.g., stemming, stop words removal)
    return text.lower()

def main():
    # Read input arguments
    answer = preprocess(sys.argv[1])
    key_answer = preprocess(sys.argv[2])

    # Calculate TF-IDF
    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform([answer, key_answer])

    # Calculate cosine similarity
    cos_sim = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0]

    # Calculate score
    score = int(cos_sim * 100)

    # Prepare the result
    result = {
        'processedAnswer': answer,
        'processedKeyAnswer': key_answer,
        'cosineSimilarity': cos_sim,
        'score': score
    }

    # Print the result as JSON
    print(json.dumps(result))

if __name__ == "__main__":
    main()
