import React, { useState } from 'react';
import { Dialog } from '@/components/ui/dialog';
import { Card } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Calendar, MapPin, Clock, Users, X } from 'lucide-react';

const TripModal = ({ trip, onClose, onJoin }) => {
  const [showRegistration, setShowRegistration] = useState(false);

  const handleJoinClick = () => {
    setShowRegistration(true);
  };

  return (
    <Dialog open={true} onOpenChange={onClose}>
      <div className="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div className="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
          <div className="sticky top-0 z-10 flex justify-end p-4">
            <button onClick={onClose} className="p-2 hover:bg-gray-100 rounded-full">
              <X className="h-6 w-6 text-gray-500" />
            </button>
          </div>

          {!showRegistration ? (
            <div className="p-6 space-y-6">
              {/* Image Gallery */}
              <div className="grid grid-cols-4 gap-4 h-80">
                <div className="col-span-2 row-span-2">
                  <img src={trip.images[0]?.photo_path} alt={trip.trip_name} className="w-full h-full object-cover rounded-xl" />
                </div>
                <div className="grid grid-cols-2 col-span-2 gap-4">
                  {trip.images.slice(1, 5).map((image, idx) => (
                    <img key={idx} src={image.photo_path} alt={trip.trip_name} className="w-full h-36 object-cover rounded-xl" />
                  ))}
                </div>
              </div>

              {/* Trip Details */}
              <div className="space-y-6">
                <div className="flex justify-between items-center">
                  <h1 className="text-3xl font-bold text-gray-900">{trip.trip_name}</h1>
                  <span className="text-2xl font-bold text-orange-500">
                    Rp {new Intl.NumberFormat('id-ID').format(trip.price)}
                  </span>
                </div>

                <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                  <div className="flex items-center space-x-2">
                    <Calendar className="h-5 w-5 text-orange-500" />
                    <span className="text-sm">{trip.start_date} - {trip.end_date}</span>
                  </div>
                  <div className="flex items-center space-x-2">
                    <MapPin className="h-5 w-5 text-orange-500" />
                    <span className="text-sm">{trip.address}</span>
                  </div>
                  <div className="flex items-center space-x-2">
                    <Clock className="h-5 w-5 text-orange-500" />
                    <span className="text-sm">2 Days</span>
                  </div>
                  <div className="flex items-center space-x-2">
                    <Users className="h-5 w-5 text-orange-500" />
                    <span className="text-sm">{trip.registrations?.length || 0}/{trip.capacity} Spots</span>
                  </div>
                </div>

                <div className="prose max-w-none">
                  <h2 className="text-xl font-semibold text-gray-900">About the Trip</h2>
                  <p className="text-gray-600">{trip.description}</p>
                </div>

                <Button 
                  onClick={handleJoinClick}
                  className="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-xl text-lg font-semibold"
                >
                  Join Trip Now
                </Button>
              </div>
            </div>
          ) : (
            <RegistrationForm 
              trip={trip} 
              onClose={() => setShowRegistration(false)}
              onSuccess={onClose}
            />
          )}
        </div>
      </div>
    </Dialog>
  );
};

const RegistrationForm = ({ trip, onClose, onSuccess }) => {
  const [formData, setFormData] = useState({
    full_name: '',
    age: '',
    whatsapp: '',
    emergency_contact: '',
    instagram: '',
    terms: false
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch(`/trips/${trip.id}/register`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
      });

      if (response.ok) {
        onSuccess();
      }
    } catch (error) {
      console.error('Registration failed:', error);
    }
  };

  return (
    <div className="p-6 space-y-6">
      <h2 className="text-2xl font-bold text-gray-900">Register for {trip.trip_name}</h2>
      
      <form onSubmit={handleSubmit} className="space-y-6">
        <div className="space-y-4">
          <div>
            <label className="block text-sm font-medium text-gray-700">Full Name</label>
            <input
              type="text"
              value={formData.full_name}
              onChange={(e) => setFormData({...formData, full_name: e.target.value})}
              className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
              required
            />
          </div>
          
          <div>
            <label className="block text-sm font-medium text-gray-700">Age</label>
            <input
              type="number"
              value={formData.age}
              onChange={(e) => setFormData({...formData, age: e.target.value})}
              className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
              required
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700">WhatsApp Number</label>
            <input
              type="tel"
              value={formData.whatsapp}
              onChange={(e) => setFormData({...formData, whatsapp: e.target.value})}
              className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
              required
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700">Emergency Contact</label>
            <input
              type="tel"
              value={formData.emergency_contact}
              onChange={(e) => setFormData({...formData, emergency_contact: e.target.value})}
              className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
              required
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700">Instagram Account</label>
            <input
              type="text"
              value={formData.instagram}
              onChange={(e) => setFormData({...formData, instagram: e.target.value})}
              className="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
              required
            />
          </div>

          <div className="flex items-center">
            <input
              type="checkbox"
              checked={formData.terms}
              onChange={(e) => setFormData({...formData, terms: e.target.checked})}
              className="h-4 w-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500"
              required
            />
            <label className="ml-2 block text-sm text-gray-700">
              I agree to the terms and conditions
            </label>
          </div>
        </div>

        <div className="flex space-x-4">
          <Button
            type="button"
            onClick={onClose}
            className="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl"
          >
            Back
          </Button>
          <Button
            type="submit"
            className="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl"
          >
            Submit Registration
          </Button>
        </div>
      </form>
    </div>
  );
};

export default function TripCard({ trip }) {
  const [showModal, setShowModal] = useState(false);

  return (
    <>
      <Card 
        onClick={() => setShowModal(true)}
        className="group cursor-pointer bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all overflow-hidden"
      >
        <div className="relative">
          <img 
            src={trip.images[0]?.photo_path} 
            alt={trip.trip_name}
            className="w-full h-56 object-cover"
          />
          <div className="absolute top-4 right-4">
            <span className="bg-orange-500 text-white text-sm font-medium px-3 py-1 rounded-full">
              2 Days
            </span>
          </div>
        </div>

        <div className="p-6">
          <h3 className="text-xl font-bold text-gray-900 mb-3 group-hover:text-orange-500 transition-colors">
            {trip.trip_name}
          </h3>
          
          <div className="space-y-2 mb-4">
            <div className="flex items-center text-gray-600">
              <Calendar className="w-5 h-5" />
              <span className="ml-2 text-sm">{trip.start_date} - {trip.end_date}</span>
            </div>
            <div className="flex items-center text-gray-600">
              <MapPin className="w-5 h-5" />
              <span className="ml-2 text-sm">{trip.address}</span>
            </div>
          </div>

          <div className="flex justify-between items-center pt-4 border-t border-gray-100">
            <div>
              <p className="text-sm text-gray-500">Starting from</p>
              <p className="text-xl font-bold text-orange-500">
                Rp {new Intl.NumberFormat('id-ID').format(trip.price)}
              </p>
            </div>
            <div className="bg-orange-50 p-2 rounded-full group-hover:bg-orange-100 transition-all">
              <Calendar className="h-5 w-5 text-orange-500" />
            </div>
          </div>
        </div>
      </Card>

      {showModal && (
        <TripModal
          trip={trip}
          onClose={() => setShowModal(false)}
          onJoin={() => {}}
        />
      )}
    </>
  );
}