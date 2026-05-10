import os
import numpy as np
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split
from sklearn.metrics import mean_squared_error, r2_score
import joblib

def generate_synthetic_data_for_variety(variety, num_samples=200):
    """
    Generate synthetic data untuk jenis mangga tertentu
    """
    np.random.seed(42)
    X_data = []
    y_data = []
    
    # Parameter per varietas
    variety_params = {
        'Harum Manis': {
            'hue_range_ripe': (15, 45), 'ar_ideal': 1.5, 'densitas': 1.02,
            'weight_range': (250, 500), 'kontras_ripe': (30, 100), 'homogen_ripe': (0.65, 0.85)
        },
        'Gedong Gincu': {
            'hue_range_ripe': [(0, 15), (170, 179)], 'ar_ideal': 1.15, 'densitas': 0.95,
            'weight_range': (200, 350), 'kontras_ripe': (25, 90), 'homogen_ripe': (0.60, 0.80)
        },
        'Manalagi': {
            'hue_range_ripe': (35, 85), 'ar_ideal': 1.1, 'densitas': 1.08,
            'weight_range': (300, 600), 'kontras_ripe': (40, 110), 'homogen_ripe': (0.60, 0.80)
        },
        'Golek': {
            'hue_range_ripe': (15, 45), 'ar_ideal': 2.0, 'densitas': 0.98,
            'weight_range': (200, 400), 'kontras_ripe': (30, 100), 'homogen_ripe': (0.65, 0.85)
        },
        'Apel': {
            'hue_range_ripe': (15, 85), 'ar_ideal': 1.05, 'densitas': 1.05,
            'weight_range': (250, 450), 'kontras_ripe': (35, 105), 'homogen_ripe': (0.60, 0.82)
        },
        'Kweni': {
            'hue_range_ripe': (15, 45), 'ar_ideal': 1.3, 'densitas': 0.97,
            'weight_range': (150, 250), 'kontras_ripe': (25, 95), 'homogen_ripe': (0.62, 0.84)
        },
        'Madu': {
            'hue_range_ripe': (15, 45), 'ar_ideal': 1.5, 'densitas': 1.03,
            'weight_range': (300, 550), 'kontras_ripe': (30, 100), 'homogen_ripe': (0.65, 0.85)
        },
        'Podang': {
            'hue_range_ripe': (15, 45), 'ar_ideal': 1.45, 'densitas': 1.01,
            'weight_range': (250, 450), 'kontras_ripe': (30, 100), 'homogen_ripe': (0.65, 0.85)
        },
    }
    
    params = variety_params.get(variety, variety_params['Harum Manis'])
    
    for _ in range(num_samples):
        # Random status: 60% matang, 20% mentah, 20% setengah matang
        status = np.random.choice(['mentah', 'setengah', 'matang', 'busuk'], 
                                  p=[0.2, 0.2, 0.5, 0.1])
        
        # Panjang (cm) berdasarkan varietas
        if params['ar_ideal'] > 1.5:  # Mangga lonjong
            panjang_cm = np.random.uniform(12.0, 20.0)
        else:  # Mangga bulat
            panjang_cm = np.random.uniform(8.0, 14.0)
            
        lebar_cm = panjang_cm / params['ar_ideal']
        
        # Berat (volume * densitas)
        volume = panjang_cm * lebar_cm * lebar_cm * 0.5236
        berat_gr = volume * params['densitas']
        berat_gr = min(max(berat_gr, params['weight_range'][0]), params['weight_range'][1])
        
        if status == 'mentah':
            mean_h = np.random.uniform(45.0, 85.0)
            mean_s = np.random.uniform(80.0, 180.0)
            mean_v = np.random.uniform(80.0, 180.0)
            kontras = np.random.uniform(150.0, 300.0)
            homogenitas = np.random.uniform(0.30, 0.55)
            skor = np.random.uniform(50.0, 68.0)
            
        elif status == 'setengah':
            # Ambil nilai tengah hue range matang
            if isinstance(params['hue_range_ripe'][0], tuple):
                # Untuk Gedong Gincu (warna merah)
                mean_h = np.random.uniform(5.0, 12.0)
            else:
                mean_h = np.random.uniform(params['hue_range_ripe'][0] - 10, 
                                          params['hue_range_ripe'][0] + 5)
            mean_s = np.random.uniform(120.0, 200.0)
            mean_v = np.random.uniform(120.0, 200.0)
            kontras = np.random.uniform(80.0, 180.0)
            homogenitas = np.random.uniform(0.50, 0.70)
            skor = np.random.uniform(68.0, 85.0)
            
        elif status == 'matang':
            if isinstance(params['hue_range_ripe'][0], tuple):
                mean_h = np.random.uniform(8.0, 12.0)  # Warna merah
            else:
                mean_h = np.random.uniform(params['hue_range_ripe'][0], 
                                          params['hue_range_ripe'][1])
            mean_s = np.random.uniform(150.0, 250.0)
            mean_v = np.random.uniform(150.0, 250.0)
            kontras = np.random.uniform(params['kontras_ripe'][0], 
                                        params['kontras_ripe'][1])
            homogenitas = np.random.uniform(params['homogen_ripe'][0], 
                                           params['homogen_ripe'][1])
            skor = np.random.uniform(85.0, 98.0)
            
        else:  # busuk
            mean_h = np.random.uniform(0.0, 30.0)
            mean_s = np.random.uniform(40.0, 120.0)
            mean_v = np.random.uniform(30.0, 90.0)
            kontras = np.random.uniform(250.0, 550.0)
            homogenitas = np.random.uniform(0.10, 0.35)
            skor = np.random.uniform(15.0, 45.0)
        
        # Tambahkan sedikit noise agar model lebih robust
        mean_h += np.random.normal(0, 2)
        mean_s += np.random.normal(0, 5)
        mean_v += np.random.normal(0, 5)
        
        features = [mean_h, mean_s, mean_v, kontras, homogenitas, panjang_cm, berat_gr]
        X_data.append(features)
        y_data.append(skor)
    
    return np.array(X_data), np.array(y_data)


def train_and_save_model_with_varieties():
    """
    Training model dengan data dari semua varietas mangga
    """
    all_X = []
    all_y = []
    
    # Menghapus Lalijiwo sesuai instruksi sebelumnya
    varieties = ['Harum Manis', 'Gedong Gincu', 'Manalagi', 'Cengkir', 'Golek', 
                 'Apel', 'Kweni', 'Madu', 'Podang']
    
    for variety in varieties:
        print(f"Generating data untuk {variety}...")
        X, y = generate_synthetic_data_for_variety(variety, num_samples=150)
        all_X.append(X)
        all_y.append(y)
    
    X = np.vstack(all_X)
    y = np.concatenate(all_y)
    
    print(f"Total data: {len(X)} samples")
    
    # Training
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
    
    model = RandomForestRegressor(n_estimators=200, max_depth=15, 
                                   min_samples_split=5, random_state=42)
    model.fit(X_train, y_train)
    
    # Evaluasi
    y_pred = model.predict(X_test)
    mse = mean_squared_error(y_test, y_pred)
    r2 = r2_score(y_test, y_pred)
    
    print(f"\n=== HASIL EVALUASI MODEL ===")
    print(f"Mean Squared Error: {mse:.2f}")
    print(f"R² Score (Akurasi): {r2*100:.2f}%")
    
    # Save model
    model_path = os.path.join(os.path.dirname(__file__), 'random_forest_model.pkl')
    joblib.dump(model, model_path)
    print(f"\n[OK] Model berhasil disimpan di: {model_path}")


if __name__ == "__main__":
    train_and_save_model_with_varieties()
